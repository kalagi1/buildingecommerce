import React, { useEffect, useState } from "react";
import { toast } from "react-toastify";

function RoomNavigator({
  formDataHousing,
  selectedRoom,
  setSelectedRoom,
  blocks,
  setBlocks,
  selectedBlock,
  formData,
  validationErrors,
  setValidationErrors,
  haveBlock,
}) {
  const [copyValue, setCopyValue] = useState("");
  const [tempItems, setTempItems] = useState([]);
  const [copyLoading, setCopyLoading] = useState(false);

  const nextHouse = () => {
    if (selectedRoom + 1 < blocks[selectedBlock]?.roomCount) {
      const errors = formData.reduce((acc, field) => {
        if (
          !field?.className?.includes("project-disabled") &&
          field.required &&
          (!blocks[selectedBlock]?.rooms[selectedRoom][field.name] ||
            blocks[selectedBlock]?.rooms[selectedRoom][field.name] === "" ||
            blocks[selectedBlock]?.rooms[selectedRoom][field.name] ===
              "Seçiniz")
        ) {
          acc.push(field.name);
        }
        return acc;
      }, []);

      if (errors.length === 0) {
        const newBlocks = [...blocks];
        if (!newBlocks[selectedBlock].rooms[selectedRoom + 1]) {
          newBlocks[selectedBlock].rooms.push({});
        }
        setBlocks(newBlocks);
        setSelectedRoom(selectedRoom + 1);
      } else {
        scrollToError();
        setValidationErrors(errors);
      }
    }
  };

  const scrollToError = () => {
    const errorElement = document.querySelector(".error-border");
    if (errorElement) {
      window.scrollTo({
        top: errorElement.offsetTop,
        behavior: "smooth",
      });
    }
  };

  const percentOccupancy = () => {
    const requiredCount = formData.filter(
      (field) =>
        !field?.className?.includes("project-disabled") && field.required
    ).length;

    const filledCount = formData.reduce((acc, field) => {
      if (
        !field?.className?.includes("project-disabled") &&
        field.required &&
        blocks[selectedBlock]?.rooms[selectedRoom]?.[field.name] &&
        blocks[selectedBlock]?.rooms[selectedRoom][field.name] !== "" &&
        blocks[selectedBlock]?.rooms[selectedRoom][field.name] !== "Seçiniz"
      ) {
        acc++;
      }
      return acc;
    }, 0);

    return (100 * filledCount) / requiredCount;
  };

  useEffect(() => {
    var tempItems2 = [];
    if (haveBlock) {
      for (var i = 0; i < blocks.length; i++) {
        for (var j = 0; j < blocks[i].roomCount; j++) {
          if (haveBlock) {
            tempItems2.push({
              label: blocks[i].name + " " + (j + 1) + " No'lu İlan",
              value: i + "-" + j,
            });
          } else {
            if (j < selectedRoom) {
              tempItems2.push({
                label: j + 1 + " No'lu İlan",
                value: i + "-" + j,
              });
            }
          }
        }
      }
    } else {
      for (var i = 0; i < blocks[selectedBlock]?.roomCount; i++) {
        tempItems2.push({
          label: i + 1 + " No'lu İlan",
          value: i + "-" + i,
        });
      }
    }

    console.log("dadsds".tempItems2);
    setTempItems(tempItems2);
  }, [selectedBlock, selectedRoom]);

  const copyItem = (selectBlock, selectRoom) => {
    // const errors = formDataHousing.reduce((acc, field) => {
    //   if (
    //     !field?.className?.includes("project-disabled") &&
    //     field.required &&
    //     (!blocks[selectedBlock].rooms[selectedRoom][field.name] ||
    //       blocks[selectedBlock].rooms[selectedRoom][field.name] === "")
    //   ) {
    //     acc.push(field.name.replace("[]", ""));
    //   }
    //   return acc;
    // }, []);

    // if (errors.length > 0) {
    //   toast.error(
    //     "Bu ilanda zorunlu tüm alanlar dolu olmadığı için seçili ilana kopyalama işlemi yapılamaz"
    //   );
    //   return;
    // }

    setCopyLoading(true);
    console.log(blocks);
    const newBlocks = blocks.map((block, blockIndex) => {
      if (blockIndex === selectedBlock) {
        return {
          ...block,
          rooms: block.rooms.map((room, roomIndex) =>
            roomIndex === selectedRoom
              ? blocks[selectBlock].rooms[selectRoom]
              : room
          ),
        };
      }
      return block;
    });

    toast.success(
      haveBlock
        ? `${blocks[selectBlock].name} bloğun ${parseInt(selectRoom)+ 1}. nolu ilanı, ${blocks[selectedBlock].name} bloğun ${parseInt(selectedRoom) + 1}. nolu ilana kopyalandı`
        : `${(parseInt(selectRoom) + 1)}. nolu ilan, ${parseInt(selectedRoom) + 1}. nolu ilana kopyalandı`
    );
    

    setBlocks(newBlocks);
    setCopyLoading(false);
  };

  const allCopy = () => {
    var tempErrors = [];
    if(blocks.length > 0){
        formDataHousing.forEach((formDataHousing) => {
            if(!formDataHousing?.className?.includes('project-disabled')){
                if(formDataHousing.required){
                    if(blocks.length < 1){
                        tempErrors.push(formDataHousing.name.replace("[]",""))
                    }else{
                        if(!blocks[selectedBlock].rooms[selectedRoom][formDataHousing.name]){
                            tempErrors.push(formDataHousing.name.replace("[]",""))
                        }
                    }
                    
                }
            }
        })
    }

    if(tempErrors.length > 0){
        toast.error("Bu konutta zorunlu tüm alanlar dolu olmadığı için tüm konutlara kopyalama işlemi yapılamaz");
    }else{
        var tempBlocks = blocks.map((block) => {
            var tempRooms = [];
            for( var i = 0 ; i < block.roomCount; i++){
                tempRooms.push(blocks[selectedBlock].rooms[selectedRoom]);
            }

            return {
                ...block,
                rooms : tempRooms
            }
        })

        setBlocks(tempBlocks);

        toast.success("Bu konutu başarıyla tüm konutlara kopyaladınız")
    }
    
}


  return (
    <>
      <div className="bottom-housing-area align-center col-md-12">
        <div className="row">
          <div className="col-md-12 mb-10">
            <div className="row">
              <div className="col-md-12">
                <div className="row justify-content-between align-items-center">
                  <div className="col-md-4 p-0">
                    <div
                      onClick={() => {
                        if (selectedRoom !== 0) {
                          setSelectedRoom(selectedRoom - 1);
                        }
                      }}
                      className={`button-white prev-house-bottom ${
                        selectedRoom === 0 ? "disabled-button" : ""
                      }`}
                    >
                      <i className="fa fa-chevron-left mr-1"></i>
                      <span>Önceki</span>
                    </div>
                  </div>
                  <div className="col-md-4 p-0 text-center">
                    <span className="total-house-text">{selectedRoom + 1}</span>

                    <span> / </span>
                    <span className="total-house-text">
                      {blocks[selectedBlock]?.roomCount}
                    </span>
                  </div>
                  <div className="col-md-4 p-0 text-right">
                    <div
                      className={`button-white next-house-bottom ${
                        selectedRoom === blocks[selectedBlock]?.roomCount - 1
                          ? "disabled-button"
                          : ""
                      }`}
                      onClick={nextHouse}
                    >
                      <span>Sonraki</span>
                      <i className="fa fa-chevron-right ml-1"></i>
                    </div>
                  </div>
                </div>
                <hr />
              </div>
              <div className="col-md-12">
                <div className="d-flex align-items-center"
               style={{ justifyContent: "center", height: "100%" }}>
                  <div className="show-houing-order" style={{ width: "100%" }}>
                    <div
                      className="full-load"
                      style={{ width: `${percentOccupancy()}%` }}
                    ></div>
                    <span style={{position: "relative", zIndex: "99999"}}>
                      <span className="room-order-progress">
                        {selectedRoom + 1}. İlan /
                      </span>{" "}
                      <span className="percent-housing">
                        {percentOccupancy().toFixed(2)}%
                      </span>
                    </span>
                  </div>
                  {/* <div
                    className="icon ml-2"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="Doldurduğunuz ilanın doluluk oranını görüntüleyebilirsiniz"
                  >
                    <i className="fa fa-info-circle"></i>
                  </div> */}
                </div>
                <hr />
              </div>

              {tempItems.length > 1 && selectedRoom != 0 && (
                <div className="col-md-12">
                  <div className="d-flex align-items-center">
                    <div className="w-100">
                      <p className="mb-0">Bu ilana,</p>
                      <p>başka bir ilanın verilerini kopyalamak için:</p>
                      <select
                        value={copyValue}
                        onChange={(e) => {
                          var copyValues = e.target.value.split("-");
                          copyItem(
                            !haveBlock ? 0 : copyValues[0],
                            copyValues[1]
                          );
                        }}
                        className="form-control copy-item w-100"
                        disabled={selectedRoom === 0}
                      >
                        <option value="">
                          {haveBlock
                            ? "İlan Seçiniz"
                            : selectedRoom === 0
                            ? "Kopyalama işlemi için önce bir ilan seçin"
                            : "İlan Seçiniz"}
                        </option>
                        {tempItems.map((item, index) => {
                          // Sadece selectedRoom'dan küçük olanları listele, selectedRoom 0 ise gösterme
                          if (
                            selectedRoom > 0 &&
                            parseInt(item.value.split("-")[1]) < selectedRoom
                          ) {
                            return (
                              <option key={index} value={item.value}>
                                {item.label}
                              </option>
                            );
                          } else {
                            return null;
                          }
                        })}
                      </select>
                      <p className="mt-2 mb-0">
                        <span className="mr-2">veya</span>
                        <a
                          style={{
                            color: "#2196f3",
                            textDecoration: "underline",
                            cursor: "pointer",
                          }}
                          onClick={allCopy}
                        >
                          Tüm ilanlara kopyala
                        </a>
                      </p>
                    </div>
                  </div>
                </div>
              )}
            </div>
          </div>
        </div>
      </div>
    </>
  );
}

export default RoomNavigator;
