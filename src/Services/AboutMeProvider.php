<?php

namespace App\Services;

class AboutMeProvider
{
    public function transformAboutData(array $data): array {
        $transformedData = [];
        $i = 1;
        foreach ($data as $item) {

            $transformedData['info'][] = [
                'number' => $i,
                'key' => $item->getKey(),
                'value' => $item->getValue(),
            ];
            $i++;
        }

        return $transformedData;
    }
}
