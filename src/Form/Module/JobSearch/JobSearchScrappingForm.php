<?php

namespace App\Form\Module\JobSearch;

use App\Controller\Core\Application;
use App\Controller\Core\ConstantsController;
use App\Action\Dialog\DialogAction;
use App\Entity\Module\JobSearch\JobSearchSetting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobSearchScrappingForm extends AbstractType
{

    const KEY_SUBMIT              = "submit";
    const KEY_SAVE_SEARCH_SETTING = "saveSearchSetting";

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
            ->add(JobSearchSetting::KEY_URL_PATTERN, TextType::class, [
                "attr" => [
                    "placeholder" => $this->app->getTranslator()->trans("forms.JobOfferScrappingType.placeholders.urlPattern"),
                ]
            ])
            ->add(JobSearchSetting::KEY_PAGE_OFFSET_REPLACE_PATTERN, TextType::class, [
                "attr" => [
                    "placeholder" => $this->app->getTranslator()->trans("forms.JobOfferScrappingType.placeholders.pageOffsetReplacePattern"),
                ]
            ])
            ->add(JobSearchSetting::KEY_PAGE_OFFSET_STEPS, NumberType::class, [
                "attr" => [
                    "min"         => 1,
                    "placeholder" => $this->app->getTranslator()->trans("forms.JobOfferScrappingType.placeholders.pageOffsetSteps"),
                ],
                "html5" => true,
            ])
            ->add(JobSearchSetting::KEY_START_PAGE_OFFSET, NumberType::class, [
                "attr" => [
                    "min"         => 0,
                    "placeholder" => $this->app->getTranslator()->trans("forms.JobOfferScrappingType.placeholders.startPageOffset"),
                ],
                "html5" => true
            ])
            ->add(JobSearchSetting::KEY_END_PAGE_OFFSET, NumberType::class, [
                "attr" => [
                    "min"         => 1,
                    "placeholder" => $this->app->getTranslator()->trans("forms.JobOfferScrappingType.placeholders.endPageOffset"),
                ],
                "html5" => true
            ])
            ->add(JobSearchSetting::KEY_BODY_QUERY_SELECTOR, TextType::class, [
                "attr" => [
                    "placeholder" => $this->app->getTranslator()->trans("forms.JobOfferScrappingType.placeholders.bodyQuerySelector"),
                ]
            ])
            ->add(JobSearchSetting::KEY_HEADER_QUERY_SELECTOR, TextType::class, [
                "attr" => [
                    "placeholder" => $this->app->getTranslator()->trans("forms.JobOfferScrappingType.placeholders.headerQuerySelector"),
                ]
            ])
            ->add(JobSearchSetting::KEY_LINK_QUERY_SELECTOR, TextType::class, [
                "attr" => [
                    "placeholder" => $this->app->getTranslator()->trans("forms.JobOfferScrappingType.placeholders.linksQuerySelector"),
                ]
            ])
            ->add(JobSearchSetting::KEY_LINKS_SKIPPING_REGEX, TextType::class, [
                "attr" => [
                    "placeholder" => $this->app->getTranslator()->trans("forms.JobOfferScrappingType.placeholders.regexForLinksSkipping"),
                ],
                "required" => false
            ])
            ->add(JobSearchSetting::KEY_ACCEPTED_KEYWORDS, TextType::class, [
                "attr" => [
                    "placeholder"       => $this->app->getTranslator()->trans("forms.JobOfferScrappingType.placeholders.acceptedKeywords"),
                    "data-is-selectize" => "true"
                ]
            ])
            ->add(JobSearchSetting::KEY_REJECTED_KEYWORDS, TextType::class, [
                "attr" => [
                    "placeholder"       => $this->app->getTranslator()->trans("forms.JobOfferScrappingType.placeholders.rejectedKeywords"),
                    "data-is-selectize" => "true",
                ]
            ])
            ->add( self::KEY_SUBMIT, SubmitType::class, [
                "attr" => [
                    "data-menu-elements-ids-to-hide" => '["' . ConstantsController::MENU_ELEMENT_JOB_SEARCH_LOAD_SETTING . '"]',
                    "data-ajax-form-submit"          => "true",
                    "class"                          => "btn-primary btn",
                ]
            ])
            ->add( self::KEY_SAVE_SEARCH_SETTING, SubmitType::class, [
                "attr" => [
                    "data-bootbox-callback-type-template-name"  => DialogAction::TEMPLATE_TYPE_SAVE_SEARCH_SETTINGS,
                    "data-call-bootbox-dialog"                  => "true",
                    "data-bootbox-size"                         => "large",
                    "data-bootbox-type"                         => "confirm",
                    "data-bootbox-callback-type"                => "load-template",
                    "class"                                     => "btn-primary btn",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => JobSearchSetting::class,
            "allow_extra_fields" => true,
            "csrf_protection"    => false,
        ]);
    }
}
