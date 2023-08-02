import React from 'react';
import { createBrowserRouter, createRoutesFromElements, Route, RouterProvider, Link } from 'react-router-dom';

import ProtectedRoute from './ProtectedRoute';
import LoginPage from '../pages/login';
import RegisterPage from '../pages/register';
import ResetPasswordPage from '../pages/reset-password';

const router = createBrowserRouter(
    createRoutesFromElements(
        <>
            <Route
                path="/"
                element={
                    <ProtectedRoute token="">
                        <div>Home Route</div>
                    </ProtectedRoute>
                    // <div>
                    //     Helo client! <br />
                    //     <Link to="/login">login</Link>
                    //     <br />
                    //     <Link to="/register">Register</Link>
                    // </div>
                }
            />
            <Route path="/register" element={<RegisterPage />} />
            <Route path="/login" element={<LoginPage />} />
            <Route path="/reset-password" element={<ResetPasswordPage />} />
            {/* <Route
                path="/"
                element={
                    <ProtectedRoute token="">
                        <div>home route</div>
                    </ProtectedRoute>
                }
            /> */}
        </>
    ),
    {
        basename: '/client',
    }
);

const Router = () => <RouterProvider router={router} />;

export default Router;
