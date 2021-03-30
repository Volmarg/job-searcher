/**
 * @description represents the JobSearchSetting entity data
 */
export default class JobSearchSettingDto {
    private _urlPattern               : string;
    private _startPageOffset          : number;
    private _endPageOffset            : number;
    private _pageOffsetSteps          : number;
    private _pageOffsetReplacePattern : string;
    private _bodyQuerySelector        : string;
    private _headerQuerySelector      : string;
    private _linkQuerySelector        : string;
    private _linksSkippingRegex       : string;
    private _acceptedKeywords         : Array<string>;
    private _rejectedKeywords         : Array<string>;

    get urlPattern(): string {
        return this._urlPattern;
    }

    set urlPattern(value: string) {
        this._urlPattern = value;
    }

    get startPageOffset(): number {
        return this._startPageOffset;
    }

    set startPageOffset(value: number) {
        this._startPageOffset = value;
    }

    get endPageOffset(): number {
        return this._endPageOffset;
    }

    set endPageOffset(value: number) {
        this._endPageOffset = value;
    }

    get pageOffsetSteps(): number {
        return this._pageOffsetSteps;
    }

    set pageOffsetSteps(value: number) {
        this._pageOffsetSteps = value;
    }

    get pageOffsetReplacePattern(): string {
        return this._pageOffsetReplacePattern;
    }

    set pageOffsetReplacePattern(value: string) {
        this._pageOffsetReplacePattern = value;
    }

    get bodyQuerySelector(): string {
        return this._bodyQuerySelector;
    }

    set bodyQuerySelector(value: string) {
        this._bodyQuerySelector = value;
    }

    get headerQuerySelector(): string {
        return this._headerQuerySelector;
    }

    set headerQuerySelector(value: string) {
        this._headerQuerySelector = value;
    }

    get linkQuerySelector(): string {
        return this._linkQuerySelector;
    }

    set linkQuerySelector(value: string) {
        this._linkQuerySelector = value;
    }

    get linksSkippingRegex(): string {
        return this._linksSkippingRegex;
    }

    set linksSkippingRegex(value: string) {
        this._linksSkippingRegex = value;
    }

    get acceptedKeywords(): Array<string> {
        return this._acceptedKeywords;
    }

    set acceptedKeywords(value: Array<string>) {
        this._acceptedKeywords = value;
    }

    get rejectedKeywords(): Array<string> {
        return this._rejectedKeywords;
    }

    set rejectedKeywords(value: Array<string>) {
        this._rejectedKeywords = value;
    }

    /**
     * @description creates current dto from the data delivered in the axios response
     */
    public static fromAxiosResponse(data: string): JobSearchSettingDto
    {
        let object = JSON.parse(data);

        let dto = new JobSearchSettingDto();
        dto._urlPattern               = object.urlPattern;
        dto._startPageOffset          = object.startPageOffset;
        dto._endPageOffset            = object.endPageOffset;
        dto._pageOffsetSteps          = object.pageOffsetSteps;
        dto._pageOffsetReplacePattern = object.pageOffsetReplacePattern;
        dto._bodyQuerySelector        = object.bodyQuerySelector;
        dto._headerQuerySelector      = object.headerQuerySelector;
        dto._linkQuerySelector        = object.linkQuerySelector;
        dto._linksSkippingRegex       = object.linksSkippingRegex;
        dto._acceptedKeywords         = object.acceptedKeywords;
        dto._rejectedKeywords         = object.rejectedKeywords;

        return dto;
    }
}