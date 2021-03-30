/**
 * @description handles loading content via ajax
 */
export default class AjaxContentLoad
{
    static readonly MAIN_WRAPPER_SELECTOR = ".main-container-wrapper";

    /**
     * @description Will insert given content int o main wrapper
     *
     * @param content
     */
    public static loadContentIntoMainWrapper(content: string): void
    {
        let mainWrapper       = document.querySelector(AjaxContentLoad.MAIN_WRAPPER_SELECTOR);
        mainWrapper.innerHTML = content;
    }

    /**
     * @description Will append scripts into the `.main-container-wrapper` and execute them afterwards
     *
     * @param scriptSources
     */
    public static appendAndExecuteScriptsIntoMainWrapper(scriptSources: Array<string>): void
    {
        let mainWrapper = document.querySelector(AjaxContentLoad.MAIN_WRAPPER_SELECTOR);

        for(let source of scriptSources){
            let scriptToAppend = document.createElement('SCRIPT');
            scriptToAppend.setAttribute('src', source);
            mainWrapper.appendChild(scriptToAppend);
        }
    }
}