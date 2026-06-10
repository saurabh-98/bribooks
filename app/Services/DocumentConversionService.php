<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Page;
use App\Models\Chapter;
use PhpOffice\PhpWord\IOFactory;
use Smalot\PdfParser\Parser;

class DocumentConversionService
{
    public function convert(
        int $bookId,
        string $filePath
    ): void {

        $extension = strtolower(
            pathinfo(
                $filePath,
                PATHINFO_EXTENSION
            )
        );

        $content = '';

        switch ($extension) {

            case 'pdf':

                $parser = new Parser();

                $pdf = $parser->parseFile(
                    $filePath
                );

                $content = $pdf->getText();

                break;

            case 'doc':
            case 'docx':

                $phpWord = IOFactory::load(
                    $filePath
                );

                foreach (
                    $phpWord->getSections()
                    as $section
                ) {

                    foreach (
                        $section->getElements()
                        as $element
                    ) {

                        if (
                            method_exists(
                                $element,
                                'getText'
                            )
                        ) {

                            $content .=
                                $element->getText()
                                . PHP_EOL;
                        }
                    }
                }

                break;

            default:

                throw new \Exception(
                    'Unsupported file format.'
                );
        }

        if (
            trim($content) === ''
        ) {
            return;
        }

        $book = Book::findOrFail(
            $bookId
        );

        $chapter = Chapter::create([
            'book_id'    => $book->id,
            'title'      => 'Imported Chapter',
            'sort_order' => 1,
        ]);

        $chunks = array_filter(
            explode(
                "\n\n",
                $content
            )
        );

        $pageNo = 1;

        foreach (
            $chunks as $chunk
        ) {

            Page::create([
                'chapter_id' => $chapter->id,
                'title'      => 'Page ' . $pageNo,
                'content'    => nl2br(
                    trim($chunk)
                ),
                'page_no'    => $pageNo,
            ]);

            $pageNo++;
        }
    }
}