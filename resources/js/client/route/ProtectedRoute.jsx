import { Navigate } from "react-router-dom";
// import useLocalStorage from "@/hooks/localstorage";

const ProtectedRoute = ({
  token,
  children,
}) => {
  if (!token) {
    return <Navigate to="/login" />;
  }

  return <>{children}</>;
};

export default ProtectedRoute;
