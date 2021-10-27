import React, { useContext, useState } from "react";
import { AppContext } from "../Context";
import Form from "../components/Form";



const UserTable = () => {

    const [isOpened, setIsOpened] = useState(false);


    function toggle() {
    setIsOpened(wasOpened => !wasOpened);
    }

  const {
    users,
    userLength,
    editMode,
    cancelEdit,
    updateUser,
    deleteUser,
  } = useContext(AppContext);

  // Storing users new data when they editing their info.
  const [newData, setNewData] = useState({});

  const saveBtn = () => {
    updateUser(newData);
  };

  const updateNewData = (e, field) => {
    setNewData({
      ...newData,
      [field]: e.target.value,
    });
  };

  const enableEdit = (id, email, phone, ip,) => {
    setNewData({ id, email, phone, ip,});
    editMode(id);
  };

  const deleteConfirm = (id) => {
    if (window.confirm("Are you sure?")) {
      deleteUser(id);
    }
  };

  return !userLength ? (
    <p>{userLength === null ? "Loading..." : "Please insert some users."}</p>
  ) : (

    <React.Fragment>

   
    <div className="table divTable" id="resp-table">
      <div className="resp-table-caption" id="resp-table-header">
        <div className=" resp-table-row" >
           <div className= "table-header-cell col-1" >Id</div>
          <div className= "table-header-cell" >Email</div>
          <div className= "table-header-cell" >Phone</div>
          <div className= "table-header-cell" >Location</div>
          <div className= "table-header-cell" >Edit</div>
        </div>
      </div>
      <div id="resp-table-body">
        {users.map(({ id, email, phone, ip, isEditing }) => {
          return isEditing === true ? (
            <div className=" resp-table-row" key={id} >
              <div className="table-body-cell  ">
                  
                <input
                 className="rounded-pill  p-2 border-light border-1"
                  type="id"
                  defaultValue={id}
                  onChange={(e) => updateNewData(e, "id")}
                />
              </div>
              <div className="table-body-cell  ">
                <input
                 className="rounded-pill  p-2 border-light border-1"
                  type="email"
                  defaultValue={email}
                  onChange={(e) => updateNewData(e, "email")}
                />
              </div>
              <div className="table-body-cell  ">
                <input 
                className="rounded-pill  p-2 border-light border-1"
                  type="phone"
                  defaultValue={phone}
                  onChange={(e) => updateNewData(e, "phone")}
                />
              </div>
              
              <div className="table-body-cell  ">
           
              
                <input
                 className="rounded-pill  p-2 border-light border-1"
                  type="ip"
                  defaultValue={ip}
                  onChange={(e) => updateNewData(e, "ip")}
                />
                
              </div>
              
              <div className="table-body-cell  ">
                <button className="btn green-btn  btn rounded-pill btn-outline-success m-1" onClick={() => saveBtn()}>
                  Save
                </button>
                <button
                  className="btn default-btn  btn rounded-pill btn-outline-primary m-1"
                  onClick={() => cancelEdit(id)}
                >
                  Cancel
                </button>
              </div>
            </div>
          ) : (
            <div className=" resp-table-row" key={id}>
                <div className="table-body-cell">{id}</div>
              <div className="table-body-cell">{email}</div>
              <div className="table-body-cell">{phone}</div>
              <div className="table-body-cell">{ip}</div>
              <div className="table-body-cell">
                <button
                  className="btn btn-outline-success rounded-pill"
                  onClick={() => enableEdit(id, email, phone, ip,)}
                >
                  Edit
                </button>
                <button
                  className="btn btn-outline-danger m-1 rounded-pill"
                  onClick={() => deleteConfirm(id)}
                >
                  Delete
                </button>
              </div>
            </div>

            );
           
        })}
            <div className=" resp-table-row">
                <div className="table-body-cell"></div>
                <div className="table-body-cell"></div>
                <div className="table-body-cell"></div>
                <div className="table-body-cell"></div>
                <div className="table-body-cell"><button type="button" onClick={toggle} className="btn rounded-pill btn-outline-primary ">+</button></div>
            </div>
           

            
      </div>
    </div>
    {/* <CountryFlag/> */}
    {isOpened && (
            <Form/>
            )}
    </React.Fragment>
  );
};

export default UserTable;