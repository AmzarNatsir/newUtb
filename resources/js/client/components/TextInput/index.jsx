import React from 'react';
import { useField } from 'formik';
const TextInput = ({ ...props }) => {
    // const [field, meta] = useField(props);
    return (
        <div className="flex flex-col space-y-1">
            <label htmlFor={props.name} className='capitalize font-medium text-sm'>{props.label}</label>
            <input
                className="w-full py-1 border-2 border-gray-300 px-2 rounded-md focus:outline-gray-400"
                autoComplete="off"
                type={props.type}
                name={props.name}
                onChange={props.onChange}
                value={props.value}
                // {...field}
                {...props}
            />
            {/* {meta.touched && meta.error ? (
                <div className="text-red-500 text-xs">{meta.error}</div>
            ):null} */}
        </div>
    );
};

export default TextInput;
