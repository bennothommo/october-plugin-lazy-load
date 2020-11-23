<?php namespace BennoThommo\LazyLoad;

use Lang;
use Event;
use IvoPetkov\HTML5DOMDocument;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    /**
     * @inheritDoc
     */
    public function pluginDetails()
    {
        return [
            'name' => 'bennothommo.lazyload::lang.plugin.name',
            'description' => 'bennothommo.lazyload::lang.plugin.description',
            'author' => 'Ben Thomson',
            'icon' => 'icon-picture-o'
        ];
    }

    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->registerEvents();
    }

    /**
     * Registers the event listeners for this plugin.
     *
     * @return void
     */
    protected function registerEvents()
    {
        // Add toggle in CMS Pages form
        Event::listen('backend.form.extendFields', function ($formWidget) {
            if (!$formWidget->getController() instanceof \Cms\Controllers\Index) {
                return;
            }

            if (!$formWidget->model instanceof \Cms\Classes\Page) {
                return;
            }

            // Make "Hidden" field span left
            $field = $formWidget->getField('settings[is_hidden]');
            $field->span = 'left';

            $formWidget->addTabFields([
                'settings[lazy_load]' => [
                    'tab' => 'cms::lang.editor.settings',
                    'label' => 'bennothommo.lazyload::lang.fields.lazyLoad.label',
                    'type' => 'checkbox',
                    'comment' => 'bennothommo.lazyload::lang.fields.lazyLoad.comment',
                    'span' => 'right'
                ],
            ]);

            // // Set lazy loading to on by default
            if (is_null($formWidget->model->lazy_load)) {
                $lazyField = $formWidget->getField('settings[lazy_load]');
                $lazyField->value = 1;
            }
        });

        // Process images on loading page
        Event::listen('cms.page.postprocess', function ($controller, $url, $page, $dataHolder) {
            $lazyLoad = (bool) $page->lazy_load ?? true;
            if ($lazyLoad) {
                $this->applyLazyLoading($dataHolder);
            }

            return $dataHolder;
        });
    }

    /**
     * Apply lazy loading to all applicable images in content.
     *
     * @param ArrayObject $dataHolder
     * @return void
     */
    protected function applyLazyLoading($dataHolder)
    {
        $dom = new HTML5DOMDocument();
        $dom->loadHTML($dataHolder->content);

        // Find all images
        $images = $dom->querySelectorAll('img');

        if ($images->count() > 0) {
            foreach ($images as $image) {
                // Image must have a source
                if (!$image->hasAttribute('src') && !$image->hasAttribute('srcset')) {
                    continue;
                }

                // Image must have a specified width and height attribute, and not already have a "loading" attribute
                if (
                    !$image->hasAttribute('width')
                    || !$image->hasAttribute('height')
                    || $image->hasAttribute('loading')
                ) {
                    continue;
                }

                // Add lazy loading attribute to images
                $image->setAttribute('loading', 'lazy');
            }
        }

        $dataHolder->content = $dom->saveHtml();
    }
}
