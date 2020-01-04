<?php

namespace App\Form;

use App\Controller\Application;
use App\Controller\BootboxController;
use App\Controller\ConstantsController;
use App\Controller\DialogsController;
use App\Entity\SearchSetting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobOfferScrappingType extends AbstractType
{

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
            ->add(SearchSetting::KEY_URL_PATTERN, TextType::class, [
                "attr" => [
                    "placeholder" => $this->app->getTranslator()->trans("forms.JobOfferScrappingType.placeholders.urlPattern"),
                ]
            ])
            ->add(SearchSetting::KEY_PAGE_OFFSET_REPLACE_PATTERN, TextType::class, [
                "attr" => [
                    "placeholder" => $this->app->getTranslator()->trans("forms.JobOfferScrappingType.placeholders.pageOffsetReplacePattern"),
                ]
            ])
            ->add(SearchSetting::KEY_PAGE_OFFSET_STEPS, NumberType::class, [
                "attr" => [
                    "min"         => 1,
                    "placeholder" => $this->app->getTranslator()->trans("forms.JobOfferScrappingType.placeholders.pageOffsetSteps"),
                ],
                "html5" => true,
            ])
            ->add(SearchSetting::KEY_END_PAGE_OFFSET, NumberType::class, [
                "attr" => [
                    "min"         => 1,
                    "placeholder" => $this->app->getTranslator()->trans("forms.JobOfferScrappingType.placeholders.endPageOffset"),
                ],
                "html5" => true
            ])
            ->add(SearchSetting::KEY_START_PAGE_OFFSET, NumberType::class, [
                "attr" => [
                    "min"         => 1,
                    "placeholder" => $this->app->getTranslator()->trans("forms.JobOfferScrappingType.placeholders.startPageOffset"),
                ],
                "html5" => true
            ])
            ->add(SearchSetting::KEY_BODY_QUERY_SELECTOR, TextType::class, [
                "attr" => [
                    "placeholder" => $this->app->getTranslator()->trans("forms.JobOfferScrappingType.placeholders.bodyQuerySelector"),
                ]
            ])
            ->add(SearchSetting::KEY_HEADER_QUERY_SELECTOR, TextType::class, [
                "attr" => [
                    "placeholder" => $this->app->getTranslator()->trans("forms.JobOfferScrappingType.placeholders.headerQuerySelector"),
                ]
            ])
            ->add(SearchSetting::KEY_LINK_QUERY_SELECTOR, TextType::class, [
                "attr" => [
                    "placeholder" => $this->app->getTranslator()->trans("forms.JobOfferScrappingType.placeholders.linksQuerySelector"),
                ]
            ])
            ->add(SearchSetting::KEY_LINKS_SKIPPING_REGEX, TextType::class, [
                "attr" => [
                    "placeholder" => $this->app->getTranslator()->trans("forms.JobOfferScrappingType.placeholders.regexForLinksSkipping"),
                ]
            ])
            ->add(SearchSetting::KEY_ACCEPTED_KEYWORDS, TextType::class, [
                "attr" => [
                    "placeholder"       => $this->app->getTranslator()->trans("forms.JobOfferScrappingType.placeholders.acceptedKeywords"),
                    "data-is-selectize" => "true"
                ]
            ])
            ->add(SearchSetting::KEY_REJECTED_KEYWORDS, TextType::class, [
                "attr" => [
                    "placeholder"       => $this->app->getTranslator()->trans("forms.JobOfferScrappingType.placeholders.rejectedKeywords"),
                    "data-is-selectize" => "true",
                ]
            ])
            ->add( $this->app->getTranslator()->trans("forms.buttons.submit"), SubmitType::class, [
                "attr" => [
                    "data-menu-elements-ids-to-hide" => '["' . ConstantsController::MENU_ELEMENT_JOB_SEARCH_LOAD_SETTING . '"]',
                    "data-ajax-form-submit"          => "true",
                    "class"                          => "btn-primary btn disabled",
                ]
            ])
            ->add( $this->app->getTranslator()->trans(self::KEY_SAVE_SEARCH_SETTING), SubmitType::class, [
                "attr" => [
                    "data-bootbox-callback-type-template-name"  => DialogsController::TEMPLATE_TYPE_SAVE_SEARCH_SETTINGS,
                    "data-call-bootbox-dialog"                  => "true",
                    "data-bootbox-size"                         => BootboxController::BOOTBOX_SIZE_LARGE,
                    "data-bootbox-type"                         => BootboxController::BOOTBOX_TYPE_CONFIRM,
                    "data-bootbox-callback-type"                => BootboxController::BOOTBOX_CALLBACK_TYPE_LOAD_TEMPLATE,
                    "class"                                     => "btn-primary btn disabled",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchSetting::class,
        ]);
    }
}
