import AbstractDto from "./AbstractDto";

/**
 * @description Main object used to convert standard array response from backend (upon ajax calls)
 *              might not contain all returned fields - should be expanded if needed / the same about backend
 *              ajaxResponse
 */
export default class AjaxResponseDto extends AbstractDto {

    /**
     * @type int
     */
    public code : number = 200;

    /**
     * @type string
     */
    public message : string = "";

    /**
     * @type string
     */
    public template : string = "";

    /**
     * @type boolean
     */
    public success : boolean = false;

    /**
     * @var Object
     */
    public dataBag : Object;

    /**
     * @type Array<string>
     */
    public scriptsSources : Array<String> = [];

    /**
     * Builds DTO from data array
     * @returns {AjaxResponseDto}
     * @param object
     */
    static fromAxiosResponse(object: object): AjaxResponseDto
    {
        let ajaxResponseDto = new AjaxResponseDto();

        ajaxResponseDto.code           = object.code;
        ajaxResponseDto.message        = object.message;
        ajaxResponseDto.template       = object.template;
        ajaxResponseDto.success        = object.success;
        ajaxResponseDto.dataBag        = object.dataBag;
        ajaxResponseDto.scriptsSources = object.scriptsSources;

        return ajaxResponseDto;
    }

    /**
     * @return {boolean}
     */
    isCodeSet(){
        return this.isset(this.code);
    }

    /**
     * @return {boolean}
     */
    isMessageSet(){
        return this.isset(this.message);
    }

    /**
     * @return {boolean}
     */
    isTemplateSet(){
        return this.isset(this.template);
    }

    /**
     * @return {boolean}
     */
    isSuccessSet(){
        return this.isset(this.success);
    }

    /**
     * @return {boolean}
     */
    isSuccessCode(){
        if(
                this.code >= 200
            &&  this.code < 300
        ){
            return true;
        }

        return false;
    }

    /**
     * @returns {boolean}
     */
    isInternalServerErrorCode(){
        return (this.code >= 500);
    }

    /**
     * @returns {boolean}
     */
    public isDataBagSet(): boolean
    {
        return (0 !== Object.keys(this.dataBag).length);
    }

    /**
     * @returns {boolean}
     */
    public areScriptsSet(): boolean
    {
        return ( 0 != this.scriptsSources.length );
    }
}