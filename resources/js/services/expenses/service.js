import Service from "../service";

export class CategoryService extends Service {
    url = '/rest/expenses/categories'
}

export class ExpenseService extends Service {
    url = '/rest/expenses/expenses'
}
