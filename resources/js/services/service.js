import ServiceError from "./errors";

export default class Service {
    url = ''

    async list(qs = '') {
        let config = {
            method: 'GET',
            url: this.url + '?' + qs
        }
        try {
            const result = await axios(config);
            return result.data;
        } catch (error) {
            return ServiceError.toss(error)
        }
    };

    async get(id) {
        let config = {
            method: 'GET',
            url: this.url + '/' + id
        }
        try {
            const result = await axios(config);
            return result.data;
        } catch (error) {
            return ServiceError.toss(error)
        }
    };

    async save(record) {
        let config = {
            method: record.id > 0 ? 'PUT' : 'POST',
            url: this.url + (record.id > 0 ? ('/' + record.id) : ''),
            data: record
        }
        try {
            return await axios(config);
        } catch (error) {
            return ServiceError.toss(error)
        }
    };

    async destroySingle(record) {
        let config = {
            method: 'DELETE',
            url: this.url + '/' + record.id,
        }
        try {
            return await axios(config);
        } catch (error) {
            return ServiceError.toss(error)
        }
    };

    async destroyMultiple(ids) {
        let config = {
            method: 'DELETE',
            url: this.url,
            data: {
                ids: ids
            }
        }
        try {
            return await axios(config);
        } catch (error) {
            return ServiceError.toss(error)
        }
    }
}
