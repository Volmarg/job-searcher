import {Notyf} from 'notyf';
import {NotyfHorizontalPosition, NotyfVerticalPosition} from "notyf/notyf.options";

/**
 * @description handles showing popups with messages
 *
 * @lik https://mdbootstrap.com/docs/standard/components/alerts/
 */
export default class NotyfService
{
    private static readonly TYPE_WARNING: string       = "warning";
    private static readonly TYPE_SUCCESS: string       = "_success";
    private static readonly TYPE_DANGER: string        = "danger";

    private static readonly POSITION_X_CENTER: NotyfHorizontalPosition  = "center"

    private static readonly POSITION_Y_TOP: NotyfVerticalPosition = "top";

    private notifier: Notyf;

    public constructor()
    {
        let classesNames = "w-100";

        this.notifier = new Notyf({
            types: [
                {
                    type        : NotyfService.TYPE_WARNING,
                    background  : 'rgb(255,140,0, 0.5)',
                    icon        : false,
                    className   : classesNames
                },
                {
                    type        : NotyfService.TYPE_SUCCESS,
                    background  : 'rgba(145, 221, 145, 0.5)',
                    icon        : false,
                    className   : classesNames
                },
                {
                    type        : NotyfService.TYPE_DANGER,
                    background  : 'rgb(243,78,78, 0.5)',
                    icon        : false,
                    className   : classesNames
                }
            ],
            position    : {
                x   : NotyfService.POSITION_X_CENTER,
                y   : NotyfService.POSITION_Y_TOP,
            },
            dismissible : true,
            duration    : 3500,
            ripple      : false,
        });
    }

    /**
     * @description will show green notification bar
     *
     * @param message
     */
    public showGreenNotification(message: string): void
    {
        this.notifier.open({
            type    : NotyfService.TYPE_SUCCESS,
            message : message,
        })
    }

    /**
     * @description will show red notification bar
     *
     * @param message
     */
    public showRedNotification(message: string): void
    {
        this.notifier.open({
            type    : NotyfService.TYPE_DANGER,
            message : message,
        })
    }

    /**
     * @description will show green notification bar
     *
     * @param message
     */
    public showOrangeNotification(message: string): void
    {
        this.notifier.open({
            type    : NotyfService.TYPE_WARNING,
            message : message,
        })
    }
}