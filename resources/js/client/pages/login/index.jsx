import React from 'react';
import { Formik, Form, Field } from 'formik';
import * as Yup from 'yup';
import { Link, useNavigate } from 'react-router-dom';
import TextInput from '../../components/TextInput';
import Button from '../../components/Button';

const loginSchema = Yup.object().shape({
    username: Yup.string().required('username required'),
    password: Yup.string().required('password required'),
});

const LoginPage = () => {
    const navigate = useNavigate()
    return (
        <div className="flex flex-col w-full h-screen bg-slate-50 justify-center items-center">
            <Formik
                initialValues={{
                    username: '',
                    password: '',
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
                                <p className="font-bold text-xl">Login</p>
                                <p className="font-normal text-xs">lorem ipsum dorem</p>
                            </div>
                            <div className="flex flex-col">
                                <Field name="username">
                                    {({ field, meta }) => (
                                        <>
                                            <TextInput type="text" placeholder="username" {...field} />
                                            {meta.touched && meta.error && (
                                                <div className="error text-red-500">{meta.error}</div>
                                            )}
                                        </>
                                    )}
                                </Field>
                            </div>
                            <div className="flex flex-col">
                                <Field name="password">
                                    {({ field, meta }) => (
                                        <>
                                            <TextInput type="password" placeholder="password" {...field} />
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
                        <div className="flex flex-col mt-10 space-y-4">
                            <div className="flex flex-col items-center">
                                <p>belum punya akun? </p>
                                <Link to="/register" className="text-blue-500 font-medium capitalize">
                                    register
                                </Link>
                            </div>
                            <div className="flex flex-col items-center">
                                <span>atau</span>
                            </div>
                            <div className="flex flex-col items-center">
                                <p>
                                    <Link to="/reset-password" className="text-blue-500 font-medium capitalize">
                                        reset password
                                    </Link>
                                </p>
                            </div>
                        </div>
                    </>
                )}
            </Formik>
        </div>
    );
};

export default LoginPage;
