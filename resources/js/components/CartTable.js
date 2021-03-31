import React from 'react';

const CartTable = (props) => {
    return (
        <table className="table text-center">
            <thead>
                <tr className="border border-left-0 border-right-0">
                    <th scope="col" className="border-0"/>
                    <th scope="col" className="border-0">
                        <span className="p-2">Наименование</span>
                    </th>
                    <th scope="col" className="border-0">
                        <span className="py-2">Цена</span>
                    </th>
                    <th scope="col" className="border-0">
                        <span className="py-2">Шт</span>
                    </th>
                    <th scope="col" className="border-0">
                        <span className="py-2">Сумма</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                {props.children}
            </tbody>
        </table>
    );
};

export default CartTable;

