import React, { useState, useEffect } from "react";
import CustomerApiService from "./ApiService";
import { Link } from "react-router-dom";

const CustomerList = () => {
    const [customers, setCustomers] = useState([]);
    const [currentCustomer, setCurrentCustomer] = useState(null);
    const [currentIndex, setCurrentIndex] = useState(-1);
    const [searchName, setSearchName] = useState("");

    useEffect(() => {
        retrieveCustomers();
    }, []);

    const onChangeSearchName = e => {
        const searchName = e.target.value;
        setSearchName(searchName);
    };
    const retrieveCustomers = () => {
        CustomerApiService.getCustomers()
            .then(response => {
                setCustomers(response.data);
                console.log(response.data);
            })
            .catch(e => {
                console.log(e);
            });
    };

    const refreshList = () => {
        retrieveCustomers();
        setCurrentCustomer(null);
        setCurrentIndex(-1);
    };

    const setActiveCustomer = (customer, index) => {
        setCurrentCustomer(customer);
        setCurrentIndex(index);
    };

    const findByName = () => {
        CustomerApiService.findByName(searchName)
            .then(response => {
                setCustomers(response.data);
                console.log(response.data);
            })
            .catch(e => {
                console.log(e);
            });
    };

    return (
        <div className="list row">
            <div className="col-md-8">
                <div className="input-group mb-3">
                    <input
                        type="text"
                        className="form-control"
                        placeholder="First name"
                        value={}
                        onChange={onChangeSearchName}
                    />
                    <div className="input-group-append">
                        <button
                            className="btn btn-outline-secondary"
                            type="button"
                            onClick={findByName}
                        >
                            Search
                        </button>
                    </div>
                </div>
            </div>
            <div className="col-md-6">
                <h4>Customers List</h4>

                <ul className="list-group">
                    {customers &&
                    customers.map((customer, index) => (
                        <li
                            className={
                                "list-group-item " + (index === currentIndex ? "active" : "")
                            }
                            onClick={() => setActiveCustomer(customer, index)}
                            key={index}
                        >
                            {customer.first_name}
                        </li>
                    ))}
                </ul>

                <button
                    className="m-3 btn btn-sm btn-danger"
                    onClick={removeAllCustomers}
                >
                    Remove All
                </button>
            </div>
            <div className="col-md-6">
                {currentCustomer ? (
                    <div>
                        <h4>Customer</h4>
                        <div>
                            <label>
                                <strong>First name:</strong>
                            </label>{" "}
                            {currentCustomer.first_name}
                        </div>
                        <div>
                            <label>
                                <strong>Family name:</strong>
                            </label>{" "}
                            {currentCustomer.family_name}
                        </div>

                        <Link
                            to={"/customers/" + currentCustomer.id}
                            className="badge badge-warning"
                        >
                            Edit
                        </Link>
                    </div>
                ) : (
                    <div>
                        <br />
                        <p>Please click on a Customer...</p>
                    </div>
                )}
            </div>
        </div>
    );
}

export default CustomerList;
