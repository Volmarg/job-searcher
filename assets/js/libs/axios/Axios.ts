import axios, {AxiosStatic} from "axios";

/**
 * @description contains the logic related to the axios
 */
export default class Axios {

    /**
     * @description this makes symfony think that this is ajax request
     *              otherwise the ajax calls made by axios are not falling into the `request->isXmlHttpRequest`
     */
    public static getAxiosInstanceForSymfony(): AxiosStatic
    {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        return axios;
    }

}