<?php

namespace App\Domain\Track;

use App\Entity\Attachment;
use App\Entity\Track;
use Embed\Embed;
use Embed\Extractor;

readonly class TrackVideoHelper
{
    public function __construct()
    {
    }

    public function handleVideo(Track $track): void
    {
        if (!$track->url || null !== $track->getId()) {
            return;
        }
        $videoData = $this->getVideoData($track);
        $preview = $this->getVideoPreview($videoData) ?? '';
        $embed = $this->getVideoEmbed($videoData) ?? '';

        $attachment = Attachment::fromVideoData($track->url, $preview, $embed);
        $track->addAttachment($attachment);
    }

    private function getVideoData(Track $track): ?Extractor
    {
        return $this->getUrlVideoData($track->url);
    }

    public function getUrlVideoData(?string $url): ?Extractor
    {
        return $url ? new Embed()->get($url) : null;
    }

    private function getVideoPreview(?Extractor $videoData): ?string
    {
        return $videoData?->image ? (string) $videoData->image : null;
    }

    private function getVideoEmbed(?Extractor $videoData): ?string
    {
        return $videoData?->code->html ?? null;
    }
}
