<?php


namespace App\Application\Query\User;


final class Filter
{
    private bool|null $active = null;
    private string|null $iso3 = null;

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function hasActive(): bool
    {
        return null !== $this->active;
    }

    public function getIso3(): ?string
    {
        return $this->iso3;
    }

    public function setIso3(?string $iso3): self
    {
        $this->iso3 = $iso3;

        return $this;
    }

    public function hasIso3(): bool
    {
        return null !== $this->iso3;
    }


}
