<?php

namespace App\Form\Module\Mail;

use App\Controller\Core\Application;
use App\Entity\Module\Mail\MailTemplate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailTemplateForm extends AbstractType
{
    const KEY_SAVE = "save";

    /**
     * @var Application $app
     */
    private $app;

    public function  __construct(Application $app) {
        $this->app = $app;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(MailTemplate::KEY_NAME, TextType::class, [
                "attr" => [
                    "placeholder" => $this->app->getTranslator()->trans("forms.MailTemplateType.placeholders.name"),
                ]
            ])
            ->add(MailTemplate::KEY_TITLE, TextType::class, [
                "attr" => [
                    "placeholder" => $this->app->getTranslator()->trans("forms.MailTemplateType.placeholders.title"),
                ]
            ])
            ->add(MailTemplate::KEY_DESCRIPTION, TextareaType::class, [
                "attr" => [
                    "placeholder"     => $this->app->getTranslator()->trans("forms.MailTemplateType.placeholders.description"),
                    "data-is-tinymce" => "true"
                ],
                "required" => true
            ])
            ->add( self::KEY_SAVE, SubmitType::class, [
                "attr" => [
                    "data-ajax-form-submit" => "true"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MailTemplate::class,
        ]);
    }
}
