import React, { useRef, useState } from 'react';
// import { useField } from 'formik';

const ImagePreview = () => {
    return (
        <div className="flex flex-col items-center w-full h-28 rounded-lg cursor-pointer bg-green-50 dark:hover:bg-green-800">
            test
        </div>
    );
};
const FileUpload = ({ icon, title, name, type, field, setFieldValue, ...props }) => {
    // const fileInputRef = useRef(null);
    const [img, setImg] = useState();
    // const [field, ,helpers] = useField(props);

    const handleFileChange = (evt) => {
        const file = evt.target.files[0];
        setFieldValue(name, file);
        if (file) {
            // setImg(URL.createObjectURL(file));
            setImg(file);
        }
    };

    return (
        <>
            {/* {JSON.stringify(img)} */}
            {img && (
                <img src={img} className="w-full h-28 aspect-square rounded-lg" />
            )}
                <label
                    for={name}
                    className="flex flex-col items-center justify-center w-full h-28 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"
                >
                    <div className="flex flex-col items-center justify-center pt-5 pb-6">
                        {icon}
                        <p className="mb-2 text-sm text-gray-500 dark:text-gray-400">
                            <span className="font-semibold capitalize">{title}</span>
                        </p>
                    </div>

                    <input
                        id={name}
                        type="file"
                        name={name}
                        onChange={() => handleFileChange()}
                        className="hidden"
                        {...field}
                        {...props}
                    />
                </label>

        </>
    );
};

export default FileUpload;
