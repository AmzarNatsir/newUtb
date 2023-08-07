import React from 'react';
import { Formik, Form, Field } from 'formik';
import * as Yup from 'yup';
import { Link, useNavigate } from 'react-router-dom';
import TextInput from '../../components/TextInput';
import Button from '../../components/Button';

const loginSchema = Yup.object().shape({
    email: Yup.string().email().required('email required'),
});

const ResetPasswordPage = () => {
    const navigate = useNavigate();
    return (
        <div className="flex flex-col w-full h-screen bg-slate-50 justify-center items-center">
            <Formik
                initialValues={{
                    email: '',
                }}
                validationSchema={loginSchema}
                onSubmit={(values, { setSubmitting }) => {
                    setSubmitting(true);
                    setTimeout(() => {
                        alert(JSON.stringify(values, null, 2));
                        setSubmitting(false);
                        // navigate('/register')
                    }, 1000);
                }}
            >
                {({ isSubmitting, errors }) => (
                    <>
                        <Form className="flex flex-col space-y-4 w-[22%] p-10 border border-slate-200 rounded-md bg-white">
                            <div className="flex flex-col">
                                <p className="font-bold text-xl">Reset Password</p>
                                <p className="font-normal text-xs">lorem ipsum dorem</p>
                            </div>
                            <div className="flex flex-col">
                                <Field name="email">
                                    {({ field, meta }) => (
                                        <>
                                            <TextInput type="email" placeholder="email" {...field} />
                                            {meta.touched && meta.error && (
                                                <div className="error text-red-500">{meta.error}</div>
                                            )}
                                        </>
                                    )}
                                </Field>
                            </div>
                            <div className="flex flex-col">
                                {/* {JSON.stringify(isSubmitting)} */}
                                <Button
                                    title="Submit"
                                    isLoading={isSubmitting}
                                    disabled={isSubmitting && errors ? true : false}
                                />
                            </div>
                        </Form>

                    </>
                )}
            </Formik>
        </div>
    );
};

export default ResetPasswordPage;
