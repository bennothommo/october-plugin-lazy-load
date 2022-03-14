**Please note that this repository is no longer being maintained.**<br>
Due to [a disagreement](https://github.com/wintercms/winter/issues/5) with the founders of October CMS, I will no longer be providing updates for the October CMS version of this plugin. I will keep the repository available for people to use, but will only be updating the [Winter CMS version](https://github.com/bennothommo/wn-lazy-load-plugin) of this plugin.

---
<br>

# Lazy Loading plugin

Makes October CMS pages lazy-load images by default. This uses the `loading="lazy"` attribute that is available as part
of the [HTML Living Standard](https://html.spec.whatwg.org/multipage/urls-and-fetching.html#lazy-loading-attributes) and
is [available in all modern browsers](https://caniuse.com/?search=loading), except Safari, since early 2020.

To prevent layout shifting, this attribute is only added automatically to images that have a defined `width` and
`height` attribute. It will also ignore any images that have specified their own `loading` attribute as well, allowing
developers to control the `loading` attribute as necessary.

A new setting is made available to the **Pages** form, *Lazy load images*, which allows developers to disable lazy
loading on a per-page basis.
