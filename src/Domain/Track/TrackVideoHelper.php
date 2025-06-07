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
        if (!$track->getUrl() || null !== $track->getId()) {
            return;
        }
        $videoData = $this->getVideoData($track);
        $preview = $this->getVideoPreview($videoData) ?? '';
        $embed = $this->getVideoEmbed($videoData) ?? '';

        $attachment = Attachment::fromVideoData($track->getUrl(), $preview, $embed);
        $track
            ->setPreviewUrl($preview)
            ->setVideoEmbed($embed)
            ->addAttachment($attachment);
    }

    private function getVideoData(Track $track): ?Extractor
    {
        $url = $track->getUrl();

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
