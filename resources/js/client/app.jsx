import React from 'react';
import { createRoot } from 'react-dom/client';
export function ClientApp() {
    return <h1>React Client App</h1>;
}

const domNode = document.getElementById('root');
const root = createRoot(domNode);
root.render(<ClientApp />);
