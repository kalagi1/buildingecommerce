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
    const tempItems2 = blocks.reduce((acc, block, blockIndex) => {
      for (let roomIndex = 0; roomIndex < block.roomCount; roomIndex++) {
        if (haveBlock || roomIndex < selectedRoom) {
          acc.push({
            label: haveBlock
              ? `${block.name} ${roomIndex + 1}. No'lu Konut`
              : `${roomIndex + 1}. No'lu Konut`,
            value: `${blockIndex}-${roomIndex}`,
          });
        }
      }
      return acc;
    }, []);

    setTempItems(tempItems2);
  }, [selectedBlock, selectedRoom, blocks, haveBlock]);

  const copyItem = (selectBlock, selectRoom) => {
    const errors = formDataHousing.reduce((acc, field) => {
      if (
        !field?.className?.includes("project-disabled") &&
        field.required &&
        (!blocks[selectedBlock].rooms[selectedRoom][field.name] ||
          blocks[selectedBlock].rooms[selectedRoom][field.name] === "")
      ) {
        acc.push(field.name.replace("[]", ""));
      }
      return acc;
    }, []);

    if (errors.length > 0) {
      toast.error(
        "Bu ilanda zorunlu tüm alanlar dolu olmadığı için seçili ilana kopyalama işlemi yapılamaz"
      );
      return;
    } 

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
        ? `${blocks[selectBlock].name} bloğun ${selectRoom + 1}. nolu ilanı, ${
            blocks[selectedBlock].name
          } bloğun ${selectedRoom + 1}. nolu ilana kopyalandı`
        : `${selectRoom + 1}. nolu ilan, ${
            selectedRoom + 1
          }. nolu ilana kopyalandı`
    );

    setBlocks(newBlocks);
    setCopyLoading(false);
  };

  const allCopy = () => {
    const errors = formDataHousing.reduce((acc, field) => {
      if (
        !field?.className?.includes("project-disabled") &&
        field.required &&
        (!blocks[selectedBlock].rooms[selectedRoom][field.name] ||
          blocks[selectedBlock].rooms[selectedRoom][field.name] === "")
      ) {
        acc.push(field.name.replace("[]", ""));
      }
      return acc;
    }, []);

    if (errors.length > 0) {
      toast.error(
        "Bu ilanda zorunlu tüm alanlar dolu olmadığı için tüm ilanlara kopyalama işlemi yapılamaz"
      );
    } else {
      const newBlocks = blocks.map((block) => ({
        ...block,
        rooms: Array(block.roomCount).fill(
          blocks[selectedBlock].rooms[selectedRoom]
        ),
      }));

      setBlocks(newBlocks);
      toast.success("Bu ilanı başarıyla tüm ilanlara kopyaladınız");
    }
  };

  return (
    <>
      {blocks[selectedBlock]?.roomCount > 0 && (
        <div className="bottom-housing-area align-center col-md-12">
          <div className="row">
            <div className="col-md-12 mb-10">
              <div className="row">
              <div className="col-md-12">
                  <div className="row justify-content-between align-items-center">
                    <div className="col-md-4">
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
                    <div className="col-md-4 text-center">
                      <span className="total-house-text">
                        {selectedRoom + 1}
                      </span>

                      <span> / </span>
                      <span className="total-house-text">
                        {blocks[selectedBlock]?.roomCount}
                      </span>
                    </div>
                    <div className="col-md-4 text-right">
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
                  <div className="d-flex align-items-center">
                    <div
                      className="show-houing-order"
                      style={{ width: "100%" }}
                    >
                      <div
                        className="full-load"
                        style={{ width: `${percentOccupancy()}%` }}
                      ></div>
                      <span>
                        <span className="room-order-progress">
                          {selectedRoom + 1}. İlan /
                        </span>{" "}
                        <span className="percent-housing">
                          {percentOccupancy().toFixed(2)}%
                        </span>
                      </span>
                    </div>
                    <div
                      className="icon ml-2"
                      data-toggle="tooltip"
                      data-placement="top"
                      title="Doldurduğunuz ilanın doluluk oranını görüntüleyebilirsiniz"
                    >
                      <i className="fa fa-info-circle"></i>
                    </div>
                  </div>
                  <hr />
                </div>
              
              {tempItems.length > 1 &&
                 <div className="col-md-12">
                 <div className="d-flex align-items-center">
                   <div className="w-100">
                     <p className="mb-0">Bu ilanın verilerini,</p>
                     <p>başka bir ilana kopyalamak için: </p>
                     <select
                       value={copyValue}
                       onChange={(e) => {
                         const [copyBlock, copyRoom] =
                           e.target.value.split("-");
                         copyItem(parseInt(copyBlock), parseInt(copyRoom));
                       }}
                       className="form-control copy-item w-100"
                       disabled={selectedRoom === 0 && !haveBlock}
                     >
                       <option value="">
                         {haveBlock
                           ? "İlan Seçiniz"
                           : selectedRoom === 0
                           ? "Kopyalama işlemi için önce bir ilan seçin"
                           : "İlan Seçiniz"}
                       </option>
                       {tempItems.map((item, index) => (
                         <option key={index} value={item.value}>
                           {item.label}
                         </option>
                       ))}
                     </select>
                     <p className="mt-2 mb-0">
                       <span className="mr-2">veya</span>
                       <a
                       style={{ color: "#2196f3", textDecoration: "underline", cursor :"pointer" }}
                         onClick={allCopy}
                         disabled={selectedRoom === 0 && !haveBlock}
                       >
                         Tüm ilanlara kopyala
                       </a>
                     </p>
                   </div>
                 </div>
               </div> }
              
             
              </div>
            </div>
          </div>
        </div>
      )}
    </>
  );
}

export default RoomNavigator;
