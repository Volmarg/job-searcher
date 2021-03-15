import Swal            from 'sweetalert2';
import AjaxResponseDto from "../../core/dto/AjaxResponseDto";

import 'sweetalert2/src/sweetalert2.scss'

/**
 * @link https://www.npmjs.com/package/sweetalert2
 */
export default class SweetAlert {

    /**
     * @description this function will call a dialog which is then filled with template from passed in promise
     */
    public static showSimpleAlertForDialogTemplate(templatePromise: Promise<AjaxResponseDto>)
    {
        templatePromise.then( (response) => {
            Swal.fire({
                html: response.template,
                heightAuto: true,
                width: '90%',
            });
        })

    }
}