export default class ServiceError {

    constructor(code, message) {
        this.code = code;
        this.message = message;
    }

    static toss(error) {
        if (error.response) {
            let message = '';
            switch (error.response.status) {
                case 500:
                    message = 'There is something wrong with the server. Please ask the administrator for assistance.'
                    break;
                case 419:
                    message = 'Page is already expired. Please reload or refresh the page.';
                    break;
                default:
                    message = 'Unknown error. Please ask the administrator for assistance.'
            }
            return new ServiceError('RES-' + error.response.status, message)
        } else if (error.request) {
            let message = 'Request has been failed. Please ask the administrator for assistance.'
            console.error('Request Error: ', error.request);

            return new ServiceError('REQ-000', message)
        } else {
            let message = 'Unknown error. Please ask the administrator for assistance.'
            console.error('Unknown Error', error.message);

            return new ServiceError('UNKNOWN', message)
        }
    }
}
