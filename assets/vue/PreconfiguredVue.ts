import * as vue from "vue";

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
        vue.createApp(options).mount(domElementSelector);
    }
}