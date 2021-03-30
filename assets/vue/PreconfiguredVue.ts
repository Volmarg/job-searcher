import * as vue from "vue";

/**
 * @description this class contains a logic for initializing the vue components in this project
 *              it's required to use the preconfigured vue as this is not a SPA / neither is it a
 *              standard project using <component> injection, rather a combination of
 *              - symfony (backend),
 *              - twig (render template),
 *              - vue,
 *              - ts
 */
export default class PreconfiguredVue
{
    /**
     * @description delimiters used to translate vue logic, required since twig utilizes the `{{ }}`
     */
    static readonly VUE_DEFAULT_DELIMITERS = ["[[", "]]"];

    /**
     * @description creates vue instance for dom element but uses preconfigured vue with common reusable logic,
     *              this provides the same output as creating SPA with vue in root such as body
     *
     * @param domElementSelector
     * @param options
     */
    public static createApp(domElementSelector: string, options)
    {
        //@ts-ignore
        options.delimiters = PreconfiguredVue.VUE_DEFAULT_DELIMITERS;
        let vueApp = vue.createApp(options);
        vueApp.mount(domElementSelector);
    }
}