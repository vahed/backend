import http from "../api-common";

const getCustomers = () => {
    return http.get("/customers");
};

const getProduts = () => {
    return http.get("/products");
};


export default {
    getCustomers,
    getProduts
};
