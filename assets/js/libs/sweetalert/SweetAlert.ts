import Swal            from 'sweetalert2';
import AjaxResponseDto from "../../core/dto/AjaxResponseDto";

/**
 * @description this class handles the logic for sweet alert, it's important to understand that
 *              the sweet alerts cannot be created via js library as VueJs won't be able to communicate with parent/child
 *
 *              thus the logic in this class should be reduced only to manipulate the dialog content being already
 *              present int the DOM like (hide / show).
 *
 * @link https://www.npmjs.com/package/sweetalert2
 * @link https://sweetalert2.github.io/
 */
export default class SweetAlert {

    static readonly DEFAULT_TARGET_SELECTOR = ".page-container";

    /**
     * @description will show dialog present in DOM for given id
     */
    public static showDialogForId(id: string): void
    {
        let dialogDomElement = document.getElementById(id);
        if( null === dialogDomElement ){
            throw {
                "message": `No DOM element was found for id ${id}`
            }
        }

        //todo: add some animation
        console.log(dialogDomElement);
    }

    /**
     * @description will show dialog present in DOM for given id
     */
    public static hideDialogForId(id: string): void
    {
        let dialogDomElement = document.getElementById(id);
        if( null === dialogDomElement ){
            throw {
                "message": `No DOM element was found for id ${id}`
            }
        }

        //todo: add some animation
        console.log(dialogDomElement);
    }

}