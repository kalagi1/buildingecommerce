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
  slug,
  checkedItems
}) {
  const [copyValue, setCopyValue] = useState("");
  const [tempItems, setTempItems] = useState([]);
  const [copyLoading, setCopyLoading] = useState(false);

  const nextHouse = () => {
    if (selectedRoom + 1 < blocks[selectedBlock]?.roomCount) {
      var tempErrors = [];
      const errors = formData.filter((field,acc ) => {
        if(typeCheck(field) && field.required){
          if(field?.className?.includes('--if-show-checked-')){
            var parentName = field?.className?.split("--if-show-checked-")[1];
            if(blocks[selectedBlock].rooms[selectedRoom][parentName+'[]'] != undefined && blocks[selectedBlock].rooms[selectedRoom][parentName+'[]'].length > 0 && blocks[selectedBlock].rooms[selectedRoom][parentName+'[]'] != "[]"){
              if((!blocks[selectedBlock]?.rooms[selectedRoom][field.name] || blocks[selectedBlock]?.rooms[selectedRoom][field.name] === "" || blocks[selectedBlock]?.rooms[selectedRoom][field.name] === "Seçiniz")){
                tempErrors.push(field.name);
                return field.name;
              }
            }
          }else{
            if((!blocks[selectedBlock]?.rooms[selectedRoom][field.name] || blocks[selectedBlock]?.rooms[selectedRoom][field.name] === "" || blocks[selectedBlock]?.rooms[selectedRoom][field.name] === "Seçiniz")){
              tempErrors.push(field.name);
              return field.name;
            }
          }
        }
      }, []);

      if (errors.length === 0) {
        const newBlocks = [...blocks];
        if (!newBlocks[selectedBlock].rooms[selectedRoom + 1]) {
          newBlocks[selectedBlock].rooms.push({});
        }
        setBlocks(newBlocks);
        setSelectedRoom(selectedRoom + 1);
      } else {
        scrollToErrorById(errors[0].name.replace("[]",""));
        setValidationErrors(tempErrors);
      }
    }
  };

  function getCoords(elem) {
    // crossbrowser version
    if (elem && elem.getBoundingClientRect()) {
      var box = elem.getBoundingClientRect();

      var body = document.body;
      var docEl = document.documentElement;

      var scrollTop = window.pageYOffset || docEl.scrollTop || body.scrollTop;
      var scrollLeft =
        window.pageXOffset || docEl.scrollLeft || body.scrollLeft;

      var clientTop = docEl.clientTop || body.clientTop || 0;
      var clientLeft = docEl.clientLeft || body.clientLeft || 0;

      var top = box.top + scrollTop - clientTop;
      var left = box.left + scrollLeft - clientLeft;

      return { top: Math.round(top), left: Math.round(left) };
    }
  }

  const scrollToErrorById = (id) => {
    const errorElement = document.querySelector("#"+id);
    if (errorElement) {
      window.scrollTo({
        top: getCoords(errorElement).top - 30,
        behavior: "smooth",
      });
    }
  }

  const typeCheck = (formDataHousing) => {
    if(slug == "satilik" && !formDataHousing?.className?.includes("project-disabled") && !formDataHousing?.className?.includes('project-disabled') && !formDataHousing?.className?.includes("only-show-project-rent") && !formDataHousing?.className?.includes("only-show-project-daliy-rent") && !formDataHousing?.className?.includes("only-not-show-project")){
      return true;
    }

    if(slug == "devren-satilik" && !formDataHousing?.className?.includes("project-disabled") && !formDataHousing?.className?.includes('project-disabled') && !formDataHousing?.className?.includes("only-show-project-rent") && !formDataHousing?.className?.includes("only-show-project-daliy-rent") && !formDataHousing?.className?.includes("only-not-show-project")){
      return true;
    }

    if(slug == "kiralik" && !formDataHousing?.className?.includes(' rent-disabled') && !formDataHousing?.className?.includes("only-show-project-sale") && !formDataHousing?.className?.includes("only-show-project-daliy-rent") && !formDataHousing?.className?.includes("only-not-show-project")){
      return true;
    }

    if(slug == "devren-kiralik" && !formDataHousing?.className?.includes(' rent-disabled') && !formDataHousing?.className?.includes("only-show-project-sale") && !formDataHousing?.className?.includes("only-show-project-daliy-rent") && !formDataHousing?.className?.includes("only-not-show-project")){
      return true;
    }

    if(slug == "gunluk-kiralik" && !formDataHousing?.className?.includes('daily-rent-disabled') && !formDataHousing?.className?.includes("only-show-project-rent") && !formDataHousing?.className?.includes("only-show-project-sale") && !formDataHousing?.className?.includes("only-not-show-project")){
      return true;
    }

    return false;
  }

  const percentOccupancy = () => {
    var requiredCount = 0;
    requiredCount = formData.filter(
      (field) => {
        if(typeCheck(field) && field.required){
          if(field.className.includes('--if-show-checked-')){
            var parentName = field?.className?.split("--if-show-checked-")[1];
            if(blocks[selectedBlock].rooms[selectedRoom][parentName+'[]'] != undefined && blocks[selectedBlock].rooms[selectedRoom][parentName+'[]'].length > 0 && blocks[0].rooms[0][parentName+'[]'] != "[]"){
              return true;
            }
          }else{
              return true;
          }
        }
      }
    ).length;

    const filledCount = formData.reduce((acc, field) => {
      if (
        typeCheck(field) &&
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

    setTempItems(tempItems2);
  }, [selectedBlock, selectedRoom]);

  const copyItem = (selectBlock, selectRoom) => {
    setCopyLoading(true);
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
          if(blocks.length < 1){
            tempErrors.push(formDataHousing.name.replace("[]",""))
          }else{
            if(typeCheck(formDataHousing) && formDataHousing.required){
              if(formDataHousing.className.includes('--if-show-checked-')){
                var parentName = formDataHousing?.className?.split("--if-show-checked-")[1];
                if(blocks[selectedBlock].rooms[selectedRoom][parentName+'[]'] != undefined && blocks[selectedBlock].rooms[selectedRoom][parentName+'[]'].length > 0 && blocks[selectedBlock].rooms[selectedRoom][parentName+'[]'] != "[]"){
                  if(!blocks[selectedBlock]?.rooms[selectedRoom][formDataHousing.name] || blocks[selectedBlock]?.rooms[selectedRoom][formDataHousing.name] === "" || blocks[selectedBlock]?.rooms[selectedRoom][formDataHousing.name] === "Seçiniz"){
                    tempErrors.push(formDataHousing.name.replace("[]",""))
                  }
                }
              }else{
                if(!blocks[selectedBlock]?.rooms[selectedRoom][formDataHousing.name] || blocks[selectedBlock]?.rooms[selectedRoom][formDataHousing.name] === "" || blocks[selectedBlock]?.rooms[selectedRoom][formDataHousing.name] === "Seçiniz"){
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
               style={{ justifyContent: "center", height: "100%", textAlign: "center" }}>
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
                <div className="col-md-12  mt-4 p-0">
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
