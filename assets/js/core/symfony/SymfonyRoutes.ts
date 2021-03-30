/**
 * @description contains symfony routes based reusable logic:
 *              - definitions of routes,
 *              - building route with parameters,
 */
export default class SymfonyRoutes {

    /**
     * @description will save the job search settings into the database
     */
    static readonly ROUTE_SAVE_JOB_SEARCH_SETTINGS : string = "/search-settings/ajax/save";

    /**
     * @description will handle loading the dialog html content template via action call
     */
    static readonly ROUTE_GET_DIALOG_TEMPLATE : string            = "/dialog-template/load/{templateType}";
    static readonly ROUTE_GET_DIALOG_TEMPLATE_PARAM_TEMPLATE_TYPE = "{templateType}"

    static readonly REMOVE_SEARCH_SETTING          : string = "/search-settings/ajax/remove/{id}";
    static readonly REMOVE_SEARCH_SETTING_ID_PARAM : string = "{id}";

    static readonly LOAD_SEARCH_SETTING          : string = "/search-settings/ajax/load/{id}";
    static readonly LOAD_SEARCH_SETTING_ID_PARAM : string = "{id}";

    /**
     * @description will build the final/target route by replacing the parameters in symfony route
     */
    public static buildRouteWithParameters(route: string, parameters: object): string
    {
        let finalRoute      = route;
        let parametersNames = Object.keys(parameters);
        for(let parameterName of parametersNames){
            let parameterValue = parameters[parameterName];
            finalRoute = finalRoute.replace(parameterName, parameterValue);
        }

        return finalRoute;
    }
}