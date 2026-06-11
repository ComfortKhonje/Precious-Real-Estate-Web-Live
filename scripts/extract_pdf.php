<?php

use Smalot\PdfParser\Parser;

// Usage: php scripts/extract_pdf.php "PREC Dashboard CMS UI & UX Requirements.pdf"

require __DIR__.'/../vendor/autoload.php';

$pdfPath = $argv[1] ?? __DIR__.'/../PREC Dashboard CMS UI & UX Requirements.pdf';

if (! file_exists($pdfPath)) {
    fwrite(STDERR, "PDF not found at: $pdfPath\n");
    exit(2);
}

if (! class_exists(Parser::class)) {
    fwrite(STDERR, "Smalot PDF Parser not installed. Run: composer require smalot/pdfparser\n");
    exit(3);
}

try {
    $parser = new Parser;
    $pdf = $parser->parseFile($pdfPath);
    $text = $pdf->getText();

    $outPath = __DIR__.'/../storage/prec_requirements.txt';
    file_put_contents($outPath, $text);

    echo "Extracted text written to: $outPath\n";
    exit(0);
} catch (Throwable $e) {
    fwrite(STDERR, 'Failed to extract PDF: '.$e->getMessage()."\n");
    exit(1);
}
