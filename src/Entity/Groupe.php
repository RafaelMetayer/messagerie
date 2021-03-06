<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupeRepository")
 */
class Groupe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    private $file;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="groupes")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="groupes_p")
     * @ORM\JoinColumn(nullable=false)
     */
    private $users_p;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="groupe", orphanRemoval=true)
     */
    private $messages;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addGroupe($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeGroupe($this);
        }

        return $this;
    }

    public function getUsersP(): ?user
    {
        return $this->users_p;
    }

    public function setUsersP(?user $users_p): self
    {
        $this->users_p = $users_p;

        return $this;
    }

    /**
     * @return Collection|message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setGroupe($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getGroupe() === $this) {
                $message->setGroupe(null);
            }
        }

        return $this;
    }
    public function getFile(){
        return $this->file;
    }
    public function setFile(UploadedFile $file){
        $this->file = $file;
        return $this;
    }
    public function uploadFile(){
        $name = $this -> file -> getClientOriginalName();
        $newName = $this -> renameFile($name);

        $this->photo = $newName;

        $this->file -> move($this -> dirPhoto(), $newName);
    }
    public function renameFile($name){
        return 'photo_' . time() . '_' . rand(1, 99999) . '_' . $name;
    }
    public function dirPhoto(){
        return __DIR__ . '/../../public/photo/';
    }

    public function removeFile(){
        if(file_exists( $this -> dirPhoto() . $this->image)) {
            unlink($this -> dirPhoto() . $this->image);
        }
    }
}
