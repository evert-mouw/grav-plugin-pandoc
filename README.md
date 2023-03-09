# Content by Pandoc for [Grav](http://getgrav.org/)

This is a plugin for the [Grav](http://getgrav.org/) CMS.

Now you can render your markdown using Pandoc.

[Pandoc](https://pandoc.org) is a document converter that supports many markdown extensions.

## Requirements

You need:

- The `pandoc` executable in your PATH.
- PHP exec() permission.

## Incompatible plugins

These plugins will no longer function correctly:

- _image-captions_ (but pandoc will convert img alt text to captions)
- _highlight_ (but pandoc will do that for you)
- _markdown-notices_
- _youtube_ (maybe due to load ordering, if this plugin gets executed before the youtube plugin)
- ... and probably many more

## Recommendations

- Disable Markdown extra in your `config/sytem.yaml` (`extra: false`).
- Disable markdown processing altogether in your in your `config/sytem.yaml` (`markdown: false`).
- Make sure there is something like `<base href="{{ page.url(true, true) }}/">` in your page template so images keep appearing.

## Installation

1. Download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`
2. Remove the `grav-plugin-` prefix from the name; rename this plugin directory/folder name to e.g. `pandoc`.

The plugin is enabled by default.

## Roadmap

- Make it possible to use the [pandoc server] mode, resulting in even speedier parsing and also making exec() permission optional.
- The UID in the vendor/composer was taken from [markdown-notices](https://github.com/getgrav/grav-plugin-markdown-notices) and had the last digit (0) changed (to 2). Maybe do it in a more proper way.

## Warning

I only meant to use this on my own blog; I'm a newbee in the Grav world and still struggling with setting up my blog.

_Evert Mouw_ | 2023-03-08
