<?php
namespace RakutenApi\Infrastructure\RakutenApi\NavigationApi\Dto\ItemAttribute;

readonly class ItemAttributeParams{
    public function __construct(
        public bool $showAncestors,
        public bool $showSiblings,
        public bool $showChildren
    )
    {}

    public static function fromArray(array $data): self{
        return new self(

            $data["showAncestors"]??false,
            $data["showSiblings"]??false,
            $data["showChildren"]??false,
        );
    }

    public function toArray(): array{
        return [
            "showAncestors"=>$this->showAncestors ? "true" : "false",
            "showSiblings"=>$this->showSiblings ? "true" : "false",
            "showChildren"=>$this->showChildren ? "true" : "false",
        ];
    }
}
