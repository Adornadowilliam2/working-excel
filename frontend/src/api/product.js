import { baseUrl } from "./configuration";

export const index = async () => {
    const response = await fetch(`${baseUrl}/retrieve`, {
        method: "GET",
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
        },
    });

    return await response.json();
};

export const store = async (body) => {
    const response = await fetch(`${baseUrl}/add`, {
        method: "POST",
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
        },
        body: JSON.stringify(body),
    });

    return await response.json();
};




export const update = async (body) => {
    const response = await fetch(`${baseUrl}/update`, {
        method: "POST",
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
        },
        body: JSON.stringify(body),
    });

    return await response.json();
};

export const destroy = async (id) => {
    const response = await fetch(`${baseUrl}/delete`, {
        method: "POST",
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ id }),
    });

    return await response.json();
};
