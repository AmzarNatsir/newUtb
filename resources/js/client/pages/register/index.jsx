import React from 'react';
import { Formik, Form, Field, useFormik } from 'formik';
import * as Yup from 'yup';
import { BsPersonVcard } from 'react-icons/bs';
import { TbHomeInfinity } from 'react-icons/tb';
import TextInput from '../../components/TextInput';
import FileUpload from '../../components/FileUpload';
import Button from '../../components/Button';

// upload file : foto ktp, foto lokasi usaha
// koordinat user

const registerSchema = Yup.object().shape({
    badanUsaha: Yup.string().min(2, 'Too Short!').max(50, 'Too Long!').required('Required'),
    email: Yup.string().email('Invalid email').required('Required'),
    alamat: Yup.string().min(2, 'Too Short!').max(200, 'Too Long!').required('Required'),
    kota: Yup.string().min(2, 'Too Short!').max(150, 'Too Long!').required('Required'),
    nomoHp: Yup.string().min(7, 'Too Short!').max(12, 'Too Long!').required('Required'),
    fotoKTP: Yup.mixed().required('Required'),
    fotoLokasiUsaha: Yup.mixed().required('Required').label('fotoLokasiUsaha'),
});

const RegisterPage = () => {
    return (
        <div className="flex flex-col w-full h-screen justify-center items-center">
            <Formik
                initialValues={{
                    badanUsaha: '',
                    email: '',
                    alamat: '',
                    kota: '',
                    nomoHp: '',
                    fotoKTP: null,
                    fotoLokasiUsaha: null,
                }}
                validateOnChange
                validationSchema={registerSchema}
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
                    <Form className="flex flex-col space-y-4 w-[28%] px-10 py-6 border border-slate-200 rounded-md bg-white">
                        <div className="flex flex-col">
                            <p className="font-bold text-xl">Login</p>
                            <p className="font-normal text-xs">lorem ipsum dorem</p>
                        </div>
                        <div className="flex flex-col">
                            <Field name="badanUsaha">
                                {({ field, meta }) => (
                                    <>
                                        <TextInput
                                            type="text"
                                            label="badan usaha"
                                            name="badanUsaha"
                                            placeholder="nama badan usaha"
                                            {...field}
                                        />
                                        {meta.touched && meta.error && (
                                            <div className="error text-red-500">{meta.error}</div>
                                        )}
                                    </>
                                )}
                            </Field>
                        </div>
                        <div className="flex flex-col justify-center">
                            <Field name="email">
                                {({ field, meta }) => (
                                    <>
                                        <TextInput
                                            type="email"
                                            name="email"
                                            label="email"
                                            placeholder="email"
                                            {...field}
                                        />
                                        {meta.touched && meta.error && (
                                            <div className="error text-red-500">{meta.error}</div>
                                        )}
                                    </>
                                )}
                            </Field>
                        </div>
                        <div className="flex flex-col justify-center">
                            <Field name="alamat">
                                {({ field, meta }) => (
                                    <>
                                        <TextInput
                                            type="text"
                                            name="alamat"
                                            label="alamat badan usaha"
                                            placeholder="alamat badan usaha"
                                            {...field}
                                        />
                                        {meta.touched && meta.error && (
                                            <div className="error text-red-500">{meta.error}</div>
                                        )}
                                    </>
                                )}
                            </Field>
                        </div>
                        <div className="flex flex-col justify-center">
                            <Field name="kota">
                                {({ field, meta }) => (
                                    <>
                                        <TextInput type="text" name="kota" label="kota" placeholder="kota" {...field} />
                                        {meta.touched && meta.error && (
                                            <div className="error text-red-500">{meta.error}</div>
                                        )}
                                    </>
                                )}
                            </Field>
                        </div>
                        <div className="flex flex-col justify-center">
                            <Field name="nomoHp">
                                {({ field, meta }) => (
                                    <>
                                        <TextInput
                                            type="text"
                                            name="nomoHp"
                                            label="nomor handphone"
                                            placeholder="nomor handphone"
                                            {...field}
                                        />
                                        {meta.touched && meta.error && (
                                            <div className="error text-red-500">{meta.error}</div>
                                        )}
                                    </>
                                )}
                            </Field>
                        </div>
                        <div className="flex flex-row w-full items-center justify-center gap-2">
                            <Field name="fotoKTP">
                                {({ field, form, meta }) => (
                                    <div className="flex flex-col w-full items-center">
                                        <FileUpload
                                            title="foto KTP"
                                            name="fotoKTP"
                                            icon={
                                                <BsPersonVcard className="w-6 h-6 mb-4 text-gray-500 dark:text-gray-400" />
                                            }
                                            {...field}
                                            setFieldValue={form.setFieldValue}
                                        />
                                        {meta.touched && meta.error && (
                                            <div className="error text-sm text-red-500">{meta.error}</div>
                                        )}
                                    </div>
                                )}
                            </Field>
                            <Field name="fotoLokasiUsaha">
                                {({ field, form, meta }) => (
                                    <div className="flex flex-col w-full items-center">
                                        <FileUpload
                                            title="foto lokasi usaha"
                                            name="fotoLokasiUsaha"
                                            icon={
                                                <TbHomeInfinity className="w-6 h-6 mb-4 text-gray-500 dark:text-gray-400" />
                                            }
                                            {...field}
                                            setFieldValue={form.setFieldValue}
                                        />
                                        {meta.touched && meta.error && (
                                            <div className="error text-sm text-red-500">{meta.error}</div>
                                        )}
                                    </div>
                                )}
                            </Field>
                        </div>

                        <div className="flex h-10 justify-center">
                            <Button
                                title="Register"
                                isLoading={isSubmitting}
                                disabled={isSubmitting && errors ? true : false}
                            />
                        </div>

                    </Form>
                )}
            </Formik>
        </div>
    );
};

export default RegisterPage;
