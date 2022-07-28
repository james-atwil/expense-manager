import Service from "../service";
import ServiceError from "../errors";

export class RoleService extends Service {
    url = '/rest/system/roles'
}

export class UserService extends Service {
    url = '/rest/system/users'

    async exists(user_id, field, value) {
        let config = {
            method: 'POST',
            url: this.url + '/exists',
            data: {
                id: user_id,
                field: field,
                value: value
            }
        }
        try {
            return await axios(config);
        } catch (error) {
            return ServiceError.toss(error)
        }
    }

    async changePass(record) {
        let config = {
            method: 'POST',
            url: '/rest/profile',
            data: record
        }
        try {
            return await axios(config);
        } catch (error) {
            return ServiceError.toss(error)
        }
    };
}

export class SettingsService extends Service {
    url = '/rest/system/settings'

    async list() {
        let config = {
            method: 'GET',
            url: this.url
        }
        try {
            return await axios(config);
        } catch (error) {
            return ServiceError.toss(error)
        }
    };

    async save(settings) {
        let config = {
            method: 'PUT',
            url: this.url,
            data: {
                settings: settings
            }
        }
        try {
            return await axios(config);
        } catch (error) {
            return ServiceError.toss(error)
        }
    };
}
