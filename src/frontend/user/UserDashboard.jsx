import React from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';

const UserDashboard = () => {
   return (
      <div>
         <nav className="navbar navbar-expand-lg navbar-light bg-light">
            <a className="navbar-brand" href="#">Dashboard</a>
            <button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
               <span className="navbar-toggler-icon"></span>
            </button>
            <div className="collapse navbar-collapse" id="navbarNav">
               <ul className="navbar-nav">
                  <li className="nav-item active">
                     <a className="nav-link" href="#">Home <span className="sr-only">(current)</span></a>
                  </li>
                  <li className="nav-item">
                     <a className="nav-link" href="#">Features</a>
                  </li>
                  <li className="nav-item">
                     <a className="nav-link" href="#">Pricing</a>
                  </li>
                  <li className="nav-item">
                     <a className="nav-link disabled" href="#" tabIndex="-1" aria-disabled="true">Disabled</a>
                  </li>
               </ul>
            </div>
         </nav>
         <div className="container mt-5">
            <div className="row">
               <div className="col-md-12">
                  <h1 className="text-center">User Dashboard</h1>
                  <div>
                     {/* Add your dashboard content here */}
                  </div>
               </div>
            </div>
         </div>
      </div>
   );
}

export default UserDashboard;