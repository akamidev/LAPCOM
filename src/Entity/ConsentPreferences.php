<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConsentPreferencesRepository")
 */
class ConsentPreferences
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $analyticsCookies = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $marketingCookies = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $emailMarketing = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $smsMarketing = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $dataSharing = false;

    // Getters and setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnalyticsCookies(): ?bool
    {
        return $this->analyticsCookies;
    }

    public function setAnalyticsCookies(bool $analyticsCookies): self
    {
        $this->analyticsCookies = $analyticsCookies;

        return $this;
    }

    public function getMarketingCookies(): ?bool
    {
        return $this->marketingCookies;
    }

    public function setMarketingCookies(bool $marketingCookies): self
    {
        $this->marketingCookies = $marketingCookies;

        return $this;
    }

    public function getEmailMarketing(): ?bool
    {
        return $this->emailMarketing;
    }

    public function setEmailMarketing(bool $emailMarketing): self
    {
        $this->emailMarketing = $emailMarketing;

        return $this;
    }

    public function getSmsMarketing(): ?bool
    {
        return $this->smsMarketing;
    }

    public function setSmsMarketing(bool $smsMarketing): self
    {
        $this->smsMarketing = $smsMarketing;

        return $this;
    }

    public function getDataSharing(): ?bool
    {
        return $this->dataSharing;
    }

    public function setDataSharing(bool $dataSharing): self
    {
        $this->dataSharing = $dataSharing;

        return $this;
    }
}
