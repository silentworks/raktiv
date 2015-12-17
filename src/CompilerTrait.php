<?php

namespace PeelingPixels\Raktiv;

use LightnCandy;

trait CompilerTrait
{
    public function compileRender($template, $data = [])
    {
        $compiled = LightnCandy::compile($template);
        $renderer = LightnCandy::prepare($compiled);

        return $renderer($data);
    }

    protected function parseComponent(
        $name,
        ComponentInterface $component,
        $template
    )
    {
        // match tags
        $matchedTags = $this->matchTags($name, $template);

        if (isset($matchedTags[1]) && !empty($matchedTags[1])) {
            foreach ($matchedTags[1] as $key => $matched) {
                $componentRendered = $component->render();

                // replace tags
                $template = $this->replaceTags(
                    $name,
                    $template,
                    $componentRendered
                );
            }
        }

        return $template;
    }

    private function matchTags($name, $string)
    {
        //<(Bro|Name)[^>]*>(?<content>[^<]*)
        preg_match_all("/<(" . $name . ")[^>]*>/", $string,
            $matches);
        return $matches;
    }

    private function replaceTags($name, $string, $replacements)
    {
        return preg_replace("/<(" . $name . ")[^>]*>/",
            $replacements, $string);
    }

    private function getAttributes($string)
    {
        preg_match_all("/(\S+)=[\"']?((?:.(?![\"']?\s+(?:\S+)=|[>\"']))+.)[\"']?/",
            $string, $matches);
        return $matches;
    }
}