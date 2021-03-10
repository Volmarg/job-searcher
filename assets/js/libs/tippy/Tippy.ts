import StringUtils from "../../core/utils/StringUtils";

import {Placement} from 'tippy.js'
import tippy       from 'tippy.js';

import 'tippy.js/dist/tippy.css';
import 'tippy.js/themes/light.css';

/**
 * @description this class handles displaying popups upon interacting with DOM elements
 * @link https://atomiks.github.io/tippyjs/
 */
export default class Tippy {

    static readonly DATA_ATTRIBUTE_CONTENT: string   = "tippyContent";
    static readonly DATA_ATTRIBUTE_PLACEMENT: string = "tippyPlacement";
    static readonly DEFAULT_PLACEMENT: Placement     = "top";
    static readonly DEFAULT_THEME                    = "light";

    /**
     * @description will initialize Tippy by the data attr
     *
     * Info: the `any` type is required due to the fact that Vue delivers Html element of type Data
     *       but no such type is defined for TS. Under the hood Data is just a HTMLElement so this is set to support
     *       the native HTMLElement structure and pass/mute `Data` as the `any`
     */
    public applyForElement(domElement: HTMLElement|any): void
    {
        // happens for example by datatable where there is one row with text `no records`
        if( "undefined" === typeof domElement.dataset ){
            return null;
        }

        let content   = domElement.dataset[Tippy.DATA_ATTRIBUTE_CONTENT];
        let placement = domElement.dataset[Tippy.DATA_ATTRIBUTE_PLACEMENT];

        if( StringUtils.isEmptyString(placement) ){
            placement = Tippy.DEFAULT_PLACEMENT;
        }

        if(
                !StringUtils.isEmptyString(content)
            &&  !domElement._tippy
        ){
            let tippyInstance = tippy(domElement, {
                allowHTML : true,
                theme     : Tippy.DEFAULT_THEME,
                content   : content,
                placement : placement
            });

            //@ts-ignore
            return tippyInstance;
        }
    }

}