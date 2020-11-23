# Lazy Loading plugin

Makes October CMS pages lazy-load images by default. This uses the `loading="lazy"` attribute that is available as part
of the [HTML Living Standard](https://html.spec.whatwg.org/multipage/urls-and-fetching.html#lazy-loading-attributes) and
is [available in all modern browsers](https://caniuse.com/?search=loading), except Safari, since early 2020.

To prevent layout shifting, this attribute is only added automatically to images that have a defined `width` and
`height` attribute. It will also ignore any images that have specified their own `loading` attribute as well, allowing
developers to control the `loading` attribute as necessary.

A new setting is made available to the **Pages** form, *Lazy load images*, which allows developers to disable lazy
loading on a per-page basis.
