import React from 'react';
import { createRoot } from 'react-dom/client';
import Router from './route/route';
export function ClientApp() {
    return (
        <div className="flex flex-col w-full h-screen justify-center items-center">
            <Router />
        </div>
    );
}

const domNode = document.getElementById('root');
const root = createRoot(domNode);
root.render(<ClientApp />);
