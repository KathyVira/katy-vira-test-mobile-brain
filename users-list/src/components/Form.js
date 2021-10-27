import { useState, useContext } from "react";
import { AppContext } from "../Context";



const Form = () => {
  const { insertUser } = useContext(AppContext);
  const [newUser, setNewUser] = useState({});

  // Storing the Insert User Form Data.
  const addNewUser = (e, field) => {
    setNewUser({
      ...newUser,
      [field]: e.target.value,
    });
  };

  // Inserting a new user into the Database.
  const submitUser = (e) => {
    e.preventDefault();
    insertUser(newUser);
    e.target.reset();
  };








  return (
    <form className="insertForm" onSubmit={submitUser}>
  
          <label htmlFor="_id">ID</label>
        <input
         className="col-2 rounded-pill m-2 p-2 border-light border-1"
        type="text"
        id="_id"
        onChange={(e) => addNewUser(e, "id")}
        placeholder="Enter id"
        autoComplete="off"
        required
      />
      <label htmlFor="_email">Email</label>
      <input
      className="col-2 rounded-pill m-2 p-2 border-light border-1"
        type="email"
        id="_email"
        onChange={(e) => addNewUser(e, "email")}
        placeholder="Enter email"
        autoComplete="off"
        required
      />
      <label htmlFor="_phone">Phone</label>
      <input
       className="col-2 rounded-pill m-2 p-2 border-light border-1"
        type="text"
        id="_phone"
        onChange={(e) => addNewUser(e, "phone")}
        placeholder="Enter phone"
        autoComplete="off"
        required
      />


      <label htmlFor="_ip">Ip</label>
        <input
         className="col-2 rounded-pill m-2 p-2 border-light border-1"
        type="text"
        id="_ip"
        onChange={(e) => addNewUser(e, "ip")}
        placeholder="Enter ip"
        autoComplete="off"
        required
      />
      <input type="submit" value="Insert" className=" btn rounded-pill btn-outline-primary m-2"/>
      
    </form>
  );
};

export default Form;