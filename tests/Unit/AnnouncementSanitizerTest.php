<?php

use App\Models\Announcement;

/**
 * The announcements body is rendered unescaped ({!! !!}) on the public news
 * page, so whatever survives sanitizeContent() executes in every visitor's
 * browser. strip_tags() alone was not enough — it keeps every attribute on
 * the tags it allows.
 */
test('safe formatting survives', function () {
    $html = '<p>Hello <strong>world</strong> and <a href="https://example.com">a link</a></p>';

    expect(Announcement::sanitizeContent($html))->toBe($html);
});

test('inline event handlers are stripped', function () {
    expect(Announcement::sanitizeContent('<img src=x onerror=alert(1)>'))
        ->not->toContain('onerror');

    expect(Announcement::sanitizeContent('<a href="https://example.com" onclick="steal()">ok</a>'))
        ->toBe('<a href="https://example.com">ok</a>');
});

test('javascript and vbscript URLs are stripped', function () {
    expect(Announcement::sanitizeContent('<a href="javascript:alert(1)">click</a>'))
        ->toBe('<a>click</a>');

    expect(Announcement::sanitizeContent('<a href="VBScript:msgbox(1)">click</a>'))
        ->not->toContain('msgbox');
});

test('script and iframe tags do not survive', function () {
    $output = Announcement::sanitizeContent('<script>alert(1)</script><iframe src="//evil"></iframe><p>after</p>');

    expect($output)->not->toContain('<script');
    expect($output)->not->toContain('<iframe');
    expect($output)->toContain('<p>after</p>');
});

test('inline data image URLs are still allowed', function () {
    $html = '<img src="data:image/png;base64,AAA">';

    expect(Announcement::sanitizeContent($html))->toContain('data:image/png');
});

test('non-image data URLs are stripped', function () {
    expect(Announcement::sanitizeContent('<a href="data:text/html,<script>alert(1)</script>">x</a>'))
        ->not->toContain('data:text/html');
});
