<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    '@hotwired/turbo' => [
        'version' => '7.3.0',
    ],
    'bootstrap' => [
        'version' => '5.3.3',
    ],
    '@popperjs/core' => [
        'version' => '2.11.8',
    ],
    '@uppy/core' => [
        'version' => '4.4.4',
    ],
    '@uppy/utils/lib/Translator' => [
        'version' => '6.1.3',
    ],
    'namespace-emitter' => [
        'version' => '2.0.1',
    ],
    'nanoid/non-secure' => [
        'version' => '5.1.5',
    ],
    'lodash/throttle.js' => [
        'version' => '4.17.21',
    ],
    '@uppy/store-default' => [
        'version' => '4.2.0',
    ],
    '@uppy/utils/lib/getFileType' => [
        'version' => '6.1.3',
    ],
    '@uppy/utils/lib/getFileNameAndExtension' => [
        'version' => '6.1.3',
    ],
    '@uppy/utils/lib/generateFileID' => [
        'version' => '6.1.3',
    ],
    '@uppy/utils/lib/getTimeStamp' => [
        'version' => '6.1.3',
    ],
    '@transloadit/prettier-bytes' => [
        'version' => '0.3.5',
    ],
    'mime-match' => [
        'version' => '1.0.2',
    ],
    'preact' => [
        'version' => '10.26.5',
    ],
    '@uppy/utils/lib/findDOMElement' => [
        'version' => '6.1.3',
    ],
    '@uppy/utils/lib/getTextDirection' => [
        'version' => '6.1.3',
    ],
    '@uppy/core/dist/style.min.css' => [
        'version' => '4.4.4',
        'type' => 'css',
    ],
    'wildcard' => [
        'version' => '1.1.2',
    ],
    '@uppy/dashboard' => [
        'version' => '4.1.1',
    ],
    '@uppy/status-bar' => [
        'version' => '4.0.3',
    ],
    '@uppy/informer' => [
        'version' => '4.1.0',
    ],
    '@uppy/thumbnail-generator' => [
        'version' => '4.0.0',
    ],
    '@uppy/utils/lib/findAllDOMElements' => [
        'version' => '6.0.3',
    ],
    '@uppy/utils/lib/toArray' => [
        'version' => '6.1.3',
    ],
    '@uppy/utils/lib/getDroppedFiles' => [
        'version' => '6.1.3',
    ],
    '@uppy/provider-views' => [
        'version' => '4.0.1',
    ],
    'memoize-one' => [
        'version' => '6.0.0',
    ],
    '@uppy/utils/lib/FOCUSABLE_ELEMENTS' => [
        'version' => '6.0.3',
    ],
    'lodash/debounce.js' => [
        'version' => '4.17.21',
    ],
    'classnames' => [
        'version' => '2.5.1',
    ],
    '@uppy/utils/lib/isDragDropSupported' => [
        'version' => '6.1.3',
    ],
    'preact/hooks' => [
        'version' => '10.24.3',
    ],
    '@uppy/utils/lib/VirtualList' => [
        'version' => '6.0.3',
    ],
    'shallow-equal' => [
        'version' => '3.1.0',
    ],
    '@uppy/utils/lib/truncateString' => [
        'version' => '6.0.3',
    ],
    '@uppy/dashboard/dist/style.min.css' => [
        'version' => '4.1.1',
        'type' => 'css',
    ],
    '@uppy/utils/lib/emaFilter' => [
        'version' => '6.0.2',
    ],
    '@uppy/utils/lib/prettyETA' => [
        'version' => '6.0.2',
    ],
    '@uppy/utils/lib/dataURItoBlob' => [
        'version' => '6.0.0',
    ],
    '@uppy/utils/lib/isObjectURL' => [
        'version' => '6.0.0',
    ],
    '@uppy/utils/lib/isPreviewSupported' => [
        'version' => '6.0.0',
    ],
    'exifr/dist/mini.esm.mjs' => [
        'version' => '7.1.3',
    ],
    '@uppy/utils/lib/remoteFileObjToLocal' => [
        'version' => '6.0.2',
    ],
    'p-queue' => [
        'version' => '8.0.1',
    ],
    '@uppy/status-bar/dist/style.min.css' => [
        'version' => '4.0.3',
        'type' => 'css',
    ],
    '@uppy/informer/dist/style.min.css' => [
        'version' => '4.1.0',
        'type' => 'css',
    ],
    '@uppy/provider-views/dist/style.min.css' => [
        'version' => '4.0.1',
        'type' => 'css',
    ],
    'eventemitter3' => [
        'version' => '5.0.1',
    ],
    'p-timeout' => [
        'version' => '6.1.2',
    ],
    '@uppy/xhr-upload' => [
        'version' => '4.2.1',
    ],
    '@uppy/core/lib/BasePlugin.js' => [
        'version' => '4.2.2',
    ],
    '@uppy/core/lib/EventManager.js' => [
        'version' => '4.2.2',
    ],
    '@uppy/utils/lib/RateLimitedQueue' => [
        'version' => '6.0.3',
    ],
    '@uppy/utils/lib/NetworkError' => [
        'version' => '6.0.3',
    ],
    '@uppy/utils/lib/isNetworkError' => [
        'version' => '6.0.3',
    ],
    '@uppy/utils/lib/fetcher' => [
        'version' => '6.0.3',
    ],
    '@uppy/utils/lib/fileFilters' => [
        'version' => '6.0.3',
    ],
    '@uppy/utils/lib/getAllowedMetaFields' => [
        'version' => '6.0.3',
    ],
    '@uppy/locales/lib/fr_FR' => [
        'version' => '4.2.0',
    ],
    'tom-select' => [
        'version' => '2.3.1',
    ],
    '@geoapify/geocoder-autocomplete' => [
        'version' => '2.1.0',
    ],
    '@uppy/drag-drop' => [
        'version' => '4.1.2',
    ],
    '@uppy/drag-drop/dist/style.min.css' => [
        'version' => '4.1.2',
        'type' => 'css',
    ],
    'axios' => [
        'version' => '1.7.9',
    ],
    'lodash/debounce' => [
        'version' => '4.17.21',
    ],
    'zxcvbn' => [
        'version' => '4.4.2',
    ],
    'photoswipe' => [
        'version' => '5.4.4',
    ],
    'photoswipe/dist/photoswipe.min.css' => [
        'version' => '5.4.4',
        'type' => 'css',
    ],
    'macy' => [
        'version' => '2.5.1',
    ],
    'embed-video' => [
        'version' => '2.0.4',
    ],
    'promise-polyfill' => [
        'version' => '6.1.0',
    ],
    'fetch-ponyfill' => [
        'version' => '4.1.0',
    ],
    'lodash.escape' => [
        'version' => '4.0.1',
    ],
    'url-metadata' => [
        'version' => '5.2.1',
    ],
    'cheerio' => [
        'version' => '1.0.0',
    ],
    'domutils' => [
        'version' => '3.1.0',
    ],
    'domhandler' => [
        'version' => '5.0.3',
    ],
    'cheerio-select' => [
        'version' => '2.1.0',
    ],
    'parse5' => [
        'version' => '7.1.2',
    ],
    'parse5-htmlparser2-tree-adapter' => [
        'version' => '7.0.0',
    ],
    'dom-serializer' => [
        'version' => '2.0.0',
    ],
    'htmlparser2' => [
        'version' => '9.1.0',
    ],
    'domelementtype' => [
        'version' => '2.3.0',
    ],
    'css-what' => [
        'version' => '6.1.0',
    ],
    'css-select' => [
        'version' => '5.1.0',
    ],
    'boolbase' => [
        'version' => '1.0.0',
    ],
    'entities/lib/decode.js' => [
        'version' => '4.5.0',
    ],
    'entities/lib/escape.js' => [
        'version' => '4.4.0',
    ],
    'entities' => [
        'version' => '4.2.0',
    ],
    'nth-check' => [
        'version' => '2.0.1',
    ],
    '@glidejs/glide' => [
        'version' => '3.7.1',
    ],
    'lodash/throttle' => [
        'version' => '4.17.21',
    ],
];
