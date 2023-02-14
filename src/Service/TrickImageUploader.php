<?php

namespace App\Service;

use Symfony\Component\String\Slugger\SluggerInterface;

class TrickImageUploader
{
    private SluggerInterface $slugger;
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function upload($formImages, $destination)
    {
        foreach ($formImages as $item) {
            if (isset($item['file']) && !empty($item['file']->getData())) {
                /** @var UploadedFile $uploadedFile */
                $uploadedFile = $item['file']->getData();

                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $this->slugger->slug($originalFilename)
                    .'-'.uniqid()
                    .'.'.$uploadedFile->guessClientExtension();

                $item->getViewData()->setName($newFilename);

                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
            }
        }
    }
}
