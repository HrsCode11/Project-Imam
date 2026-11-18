<?php
class SimplePdf {
    private array $pages = [];
    private float $w = 842; // A4 landscape
    private float $h = 595;
    private array $content = [];

    public function newPage(): void {
        if ($this->content) {
            $this->pages[] = implode("\n", $this->content);
        }
        $this->content = [];
    }

    private function enc(string $text): string {
        $converted = @iconv('UTF-8', 'Windows-1252//TRANSLIT//IGNORE', $text);
        if ($converted === false) {
            $converted = $text;
        }
        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $converted);
    }

    public function text(float $x, float $y, string $text, float $size = 10, bool $bold = false): void {
        $font = $bold ? 'F2' : 'F1';
        $pdfY = $this->h - $y;
        $this->content[] = "BT /{$font} {$size} Tf {$x} {$pdfY} Td (" . $this->enc($text) . ") Tj ET";
    }

    public function line(float $x1, float $y1, float $x2, float $y2, float $width = 0.5): void {
        $py1 = $this->h - $y1;
        $py2 = $this->h - $y2;
        $this->content[] = "{$width} w {$x1} {$py1} m {$x2} {$py2} l S";
    }

    public function rect(float $x, float $y, float $w, float $h, bool $fill = false): void {
        $py = $this->h - $y - $h;
        $op = $fill ? 'f' : 'S';
        $this->content[] = "{$x} {$py} {$w} {$h} re {$op}";
    }

    public function fillGray(float $gray): void {
        $gray = max(0, min(1, $gray));
        $this->content[] = "{$gray} g";
    }

    public function strokeGray(float $gray): void {
        $gray = max(0, min(1, $gray));
        $this->content[] = "{$gray} G";
    }

    public function resetColor(): void {
        $this->content[] = "0 g 0 G";
    }

    private function ulen(string $text): int {
        return function_exists('mb_strlen') ? mb_strlen($text) : strlen($text);
    }

    private function usubstr(string $text, int $start, ?int $length = null): string {
        if (function_exists('mb_substr')) {
            return $length === null ? mb_substr($text, $start) : mb_substr($text, $start, $length);
        }
        return $length === null ? substr($text, $start) : substr($text, $start, $length);
    }

    public function wrap(string $text, int $maxChars): array {
        $text = trim(preg_replace('/\s+/', ' ', $text));
        if ($text === '') return [''];

        $words = explode(' ', $text);
        $lines = [];
        $line = '';

        foreach ($words as $word) {
            if ($this->ulen($word) > $maxChars) {
                if ($line !== '') {
                    $lines[] = $line;
                    $line = '';
                }
                while ($this->ulen($word) > $maxChars) {
                    $lines[] = $this->usubstr($word, 0, $maxChars);
                    $word = $this->usubstr($word, $maxChars);
                }
                $line = $word;
                continue;
            }

            $candidate = $line === '' ? $word : $line . ' ' . $word;
            if ($this->ulen($candidate) <= $maxChars) {
                $line = $candidate;
            } else {
                if ($line !== '') $lines[] = $line;
                $line = $word;
            }
        }

        if ($line !== '') $lines[] = $line;
        return $lines ?: [''];
    }

    public function multiline(float $x, float $y, string $text, int $maxChars, float $size = 9.5, bool $bold = false, float $lineHeight = 12): int {
        $lines = $this->wrap($text, $maxChars);
        foreach ($lines as $i => $line) {
            $this->text($x, $y + ($i * $lineHeight), $line, $size, $bold);
        }
        return count($lines);
    }

    public function output(string $filename = 'laporan.pdf'): never {
        if ($this->content || !$this->pages) {
            $this->pages[] = implode("\n", $this->content);
        }

        $objects = [];
        $objects[1] = '<< /Type /Catalog /Pages 2 0 R >>';
        $kids = [];
        $pageObjNums = [];
        $contentObjNums = [];
        $next = 5;

        foreach ($this->pages as $i => $pageContent) {
            $pageObjNums[$i] = $next++;
            $contentObjNums[$i] = $next++;
            $kids[] = $pageObjNums[$i] . ' 0 R';
        }

        $objects[2] = '<< /Type /Pages /Kids [' . implode(' ', $kids) . '] /Count ' . count($kids) . ' >>';
        $objects[3] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica /Encoding /WinAnsiEncoding >>';
        $objects[4] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold /Encoding /WinAnsiEncoding >>';

        foreach ($this->pages as $i => $pageContent) {
            $pageNo = $pageObjNums[$i];
            $contentNo = $contentObjNums[$i];
            $objects[$pageNo] = '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 ' . $this->w . ' ' . $this->h . '] /Resources << /Font << /F1 3 0 R /F2 4 0 R >> >> /Contents ' . $contentNo . ' 0 R >>';
            $objects[$contentNo] = '<< /Length ' . strlen($pageContent) . ">>\nstream\n" . $pageContent . "\nendstream";
        }

        ksort($objects);
        $pdf = "%PDF-1.4\n%\xE2\xE3\xCF\xD3\n";
        $offsets = [0 => 0];

        foreach ($objects as $num => $body) {
            $offsets[$num] = strlen($pdf);
            $pdf .= $num . " 0 obj\n" . $body . "\nendobj\n";
        }

        $xref = strlen($pdf);
        $maxObj = max(array_keys($objects));
        $pdf .= "xref\n0 " . ($maxObj + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";
        for ($i = 1; $i <= $maxObj; $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i] ?? 0);
        }
        $pdf .= "trailer\n<< /Size " . ($maxObj + 1) . " /Root 1 0 R >>\nstartxref\n{$xref}\n%%EOF";

        // Remove any buffered whitespace/notices so the response starts with %PDF.
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        $filename = basename($filename);
        $filename = preg_replace('/[^A-Za-z0-9._-]/', '_', $filename) ?: 'laporan.pdf';

        // Force a file download instead of rendering the endpoint as a web page.
        header_remove('Content-Type');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($pdf));
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Pragma: public');
        header('Expires: 0');
        header('X-Content-Type-Options: nosniff');
        echo $pdf;
        exit;
    }
}
