import React, { useEffect, useState } from "react";
import Box from "@mui/material/Box";
import Typography from "@mui/material/Typography";
import Modal from "@mui/material/Modal";
import { dotNumberFormat, telNumberFormat } from "../../define/variables";
import {
  Alert,
  Checkbox,
  FormControlLabel,
  Grid,
  Paper,
  Switch,
  Tooltip,
} from "@mui/material";
import RoomNavigator from "./RoomNavigator";
import PayDecModal from "./PayDecModal";
import Swal from "sweetalert2";
import { toast } from "react-toastify";
function BlockRooms({
  slug,
  formDataHousing,
  anotherBlockErrors,
  selectedBlock,
  setSelectedBlock,
  selectedRoom,
  setSelectedRoom,
  blocks,
  setBlocks,
  roomCount,
  setRoomCount,
  selectedHousingType,
  allErrors,
}) {
  const [open, setOpen] = useState(false);
  const [validationErrors, setValidationErrors] = useState([]);
  const [blockName, setBlockName] = useState("");
  const [payDecOpen, setPayDecOpen] = useState(false);
  const [checkedItems, setCheckedItems] = useState(
    () => JSON.parse(localStorage.getItem("checkedItems")) || []
  );
  var formData = JSON.parse(selectedHousingType?.housing_type?.form_json);
  const [rendered, setRendered] = useState(0);
  const style = {
    position: "absolute",
    top: "50%",
    left: "50%",
    transform: "translate(-50%, -50%)",
    width: 400,
    bgcolor: "background.paper",
    boxShadow: 24,
    p: 4,
  };

  const addBlock = () => {
    setSelectedBlock(blocks.length);
    if (roomCount > 0) {
      var defaultValuues = [];
      var checkedItemsTemp = [];
      for (var i = 0; i < roomCount; i++) {
        defaultValuues.push({});
        formData.map((data) => {
          if (data?.className?.includes("project-default-checked")) {
            checkedItemsTemp.push({
              roomOrder: i,
              name: data?.name?.replace("[]", ""),
            });

            if (defaultValuues[i]) {
              defaultValuues[i][data?.name] = [data?.values[0]?.value];
            } else {
              defaultValuues.push({
                [data?.name]: [data?.values[0]?.value],
              });
            }
          }
        });
      }
      console.log(defaultValuues);
      setCheckedItems([...checkedItems, ...checkedItemsTemp]);
      setBlocks([
        ...blocks,
        {
          name: blockName,
          roomCount: roomCount,
          rooms: defaultValuues,
        },
      ]);

      setSelectedRoom(0);
      setBlockName("");
      setRoomCount(0);
      setOpen(false);
    } else {
      toast.error("Lütfen geçerli bir konut sayısı giriniz");
    }
  };

  const blockDataSet = (blockIndex, keyx, value) => {
    var newDatas = blocks.map((block, key) => {
      if (blockIndex == key) {
        var newData2 = block.rooms.map((room, keyRoom) => {
          if (keyRoom == selectedRoom) {
            return {
              ...room,
              [keyx]: value,
            };
          } else {
            return room;
          }
        });

        return {
          ...block,
          rooms: [...newData2],
        };
      } else {
        return block;
      }
    });

    var newErrors = validationErrors.filter(
      (validationError) => validationError != keyx
    );

    setValidationErrors(newErrors);

    setBlocks(newDatas);
    setRendered(rendered + 1);
  };

  const setCheckedItemsFunc = (name, checked) => {
    if (checked) {
      setCheckedItems([
        ...checkedItems,
        {
          roomOrder: selectedRoom,
          name: name.replace("[]", ""),
        },
      ]);
    } else {
      var newItems = checkedItems.filter((checkedItem) => {
        if (
          checkedItem.roomOrder == selectedRoom &&
          checkedItem.name == name.replace("[]", "")
        ) {
        } else {
          return checkedItem;
        }
      });

      setCheckedItems(newItems);
    }
  };

  useEffect(() => {
    localStorage.setItem("checkedItems", JSON.stringify(checkedItems));
  }, [checkedItems])

  const blockCheckboxDataSet = (blockIndex, keyx, value, isChecked) => {
    var newDatas = blocks.map((block, key) => {
      if (blockIndex == key) {
        var newData2 = block.rooms.map((room, keyRoom) => {
          if (keyRoom == selectedRoom) {
            if (room[keyx]) {
              if (room[keyx].includes(value)) {
                var newKeyValues = room[keyx].filter((keyVal) => {
                  if (keyVal != value) {
                    return keyVal;
                  }
                });

                return {
                  ...room,
                  [keyx]: newKeyValues,
                };
              } else {
                return {
                  ...room,
                  [keyx]: [...room[keyx], value],
                };
              }
            } else {
              return {
                ...room,
                [keyx]: [value],
              };
            }
          } else {
            return room;
          }
        });

        return {
          ...block,
          rooms: [...newData2],
        };
      } else {
        return block;
      }
    });
    setBlocks(newDatas);
    setRendered(rendered + 1);
  };

  const [isFixed, setIsFixed] = useState(false);

  useEffect(() => {
    const handleScroll = () => {
      const navigatorElement = document.getElementById("roomNavigator");
      const offsetTop = navigatorElement.offsetTop;
      const scrollTop = window.scrollY;

      if (
        scrollTop > offsetTop &&
        scrollTop < document.documentElement.scrollHeight - window.innerHeight
      ) {
        setIsFixed(true);
      } else {
        setIsFixed(false);
      }
    };

    window.addEventListener("scroll", handleScroll);
    return () => {
      window.removeEventListener("scroll", handleScroll);
    };
  }, []);

  const changeFormImage = (blockIndex, keyx, event) => {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = () => {
      var newDatas = blocks.map((block, key) => {
        if (blockIndex == key) {
          var newData2 = block.rooms.map((room, keyRoom) => {
            if (keyRoom == selectedRoom) {
              return {
                ...room,
                [keyx]: file,
                [keyx + "_imagex"]: reader.result,
              };
            } else {
              return room;
            }
          });

          return {
            ...block,
            rooms: [...newData2],
          };
        } else {
          return block;
        }
      });

      var newErrors = validationErrors.filter(
        (validationError) => validationError != keyx
      );
      setValidationErrors(newErrors);
      setBlocks(newDatas);
      setRendered(rendered + 1);
    };

    if (file) {
      reader.readAsDataURL(file);
    }
  };

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

    if(slug == "devren-kiralik" && !formDataHousing?.className?.includes('rent-disabled') && !formDataHousing?.className?.includes("only-show-project-sale") && !formDataHousing?.className?.includes("only-show-project-daliy-rent") && !formDataHousing?.className?.includes("only-not-show-project")){
      return true;
    }

    if(slug == "gunluk-kiralik" && !formDataHousing?.className?.includes('daily-rent-disabled') && !formDataHousing?.className?.includes("only-show-project-rent") && !formDataHousing?.className?.includes("only-show-project-sale") && !formDataHousing?.className?.includes("only-not-show-project")){
      return true;
    }

    return false;
  }

  const removeBlock = (key) => {
    Swal.fire({
      title: "Bloğu silmek istediğinize emin misiniz?",
      showDenyButton: false,
      showCancelButton: true,
      confirmButtonText: "Evet",
      cancelButtonText: "İptal",
    }).then((result) => {
      if (result.isConfirmed) {
        const newBlocks = blocks.filter(
          (block, blockIndex) => blockIndex !== key
        );

        // Determine the new selected block index
        let newSelectedBlock = selectedBlock;
        if (selectedBlock === key) {
          // If the removed block was selected, select the previous block if available
          newSelectedBlock = key > 0 ? key - 1 : key; // Select the previous block
        } else if (selectedBlock > key) {
          // Adjust selectedBlock index if it was after the removed block
          newSelectedBlock = selectedBlock - 1;
        }

        setSelectedBlock(newSelectedBlock);
        setBlocks(newBlocks);
      }
    });
  };

  return (
    <>
      <div className="section-title mt-5">
        <h2>Bloklar </h2>
      </div>
      <div className="card p-3 mt-3" style={{ position: "relative" }}>
        <div id="housing-forms">
          <div
            className="add-new-block"
            onClick={() => {
              setOpen(true);
            }}
          >
            <i className="fa fa-plus"></i> Yeni Ekle
          </div>
          {anotherBlockErrors.length > 0 ? (
            <Alert icon={false} className="mt-3" severity="error">
              <ul style={{ margin: 0 }}>
                {anotherBlockErrors.map((anotherBlockError) => {
                  return <li>{anotherBlockError}</li>;
                })}
              </ul>
            </Alert>
          ) : (
            ""
          )}
          {blocks.length > 0 ? (
            <div className="block-list mt-3">
              {blocks.map((block, key) => {
                return (
                  <div
                    key={key}
                    onClick={() => {
                      setSelectedBlock(key);
                      setSelectedRoom(0);
                    }}
                    className={
                      "block " + (key === selectedBlock ? "active" : "")
                    }
                  >
                    <span className="block-name">{block.name}</span>
                    <span className="block-info">
                      ({block.roomCount} İlan)
                    </span>
                    <span
                      className="remove-block"
                      onClick={(e) => {
                        e.stopPropagation(); // Prevent triggering the block click
                        removeBlock(key);
                      }}
                    >
                      Sil
                    </span>
                  </div>
                );
              })}
            </div>
          ) : (
            <p className="mb-0 mt-2">Lütfen blok ekleyiniz.</p>
          )}
        </div>
      </div>
      {blocks.length > 0 && (
        <>
          <div className="section-title mt-5">
            <h2>İlan Özellikleri </h2>
          </div>
          <div className="row">
            <div className="col-md-3">
              <div
                id="roomNavigator"
                className={`p-3 mt-3 card ${
                  isFixed ? "fixed-room-navigator" : "original-room-navigator"
                }`}
                style={{ position: "relative" }}
              >
                <RoomNavigator 
                  slug={slug}
                  formDataHousing={formDataHousing}
                  haveBlock={true}
                  validationErrors={validationErrors}
                  setValidationErrors={setValidationErrors}
                  formData={formData}
                  selectedBlock={selectedBlock}
                  blocks={blocks}
                  setBlocks={setBlocks}
                  selectedRoom={selectedRoom}
                  setSelectedRoom={setSelectedRoom}
                />
              </div>
            </div>
            <div className="col-md-9">
              <div className="p-3 mt-3 card" style={{ position: "relative" }}>
                {blocks.length > 0 ? (
                  <div className="housing-form mt-7">
                    {formData.map((data, i) => {
                        if (
                          typeCheck(data)
                        ) {
                          if (1) {
                            var isX = null;
                            if (
                              data?.className?.includes("--if-show-checked-")
                            ) {
                              isX = !checkedItems.find((checkedItem) => {
                                return (
                                  checkedItem.roomOrder == selectedRoom &&
                                  checkedItem.name ==
                                  data?.className?.split(
                                    "--if-show-checked-"
                                  )[1]
                                );
                              });
                            }
                            if (
                              !data?.className?.includes(
                                "only-not-show-project"
                              )
                            ) {
                              if (data.type == "text") {
                                return (
                                  <div
                                    className={
                                      "form-group " + (isX ? "d-none" : "")
                                    }
                                  >
                                    <label className="font-bold" htmlFor="">
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                    </label>
                                    {data?.className?.includes("price-only") ||
                                      data?.className?.includes("number-only") ? (
                                      <input
                                        id={data?.name.replace("[]", "")}
                                        type="text"
                                        value={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            : ""
                                        }
                                        onChange={(e) => {
                                          if(e.target.value.trim() != ""){
                                            blockDataSet(
                                              selectedBlock,
                                              data?.name,
                                              dotNumberFormat(e.target.value)
                                            );
                                          }else{
                                            blockDataSet(
                                              selectedBlock,
                                              data?.name,
                                              ""
                                            );
                                          }
                                        }}
                                        className={
                                          "form-control " +
                                          (validationErrors.includes(data?.name)
                                            ? "error-border"
                                            : "") +
                                          " " +
                                          (allErrors.includes(
                                            data?.name.replace("[]", "")
                                          )
                                            ? "error-border"
                                            : "")
                                        }
                                      />
                                    ) : data?.className?.includes(
                                      "tel-only"
                                    ) ? (
                                      <input
                                        id={data?.name.replace("[]", "")}
                                        type="text"
                                        value={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            : ""
                                        }
                                        onChange={(e) => {
                                          if(e.target.value.trim() != ""){
                                            blockDataSet(
                                              selectedBlock,
                                              data?.name,
                                              telNumberFormat(e.target.value)
                                            );
                                          }else{
                                            blockDataSet(
                                              selectedBlock,
                                              data?.name,
                                              ""
                                            );
                                          }
                                        }}
                                        className={
                                          "form-control " +
                                          (validationErrors.includes(data?.name)
                                            ? "error-border"
                                            : "") +
                                          " " +
                                          (allErrors.includes(
                                            data?.name.replace("[]", "")
                                          )
                                            ? "error-border"
                                            : "")
                                        }
                                      />
                                    ) : (
                                      <input
                                        id={data?.name.replace("[]", "")}
                                        type="text"
                                        value={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            : ""
                                        }
                                        onChange={(e) => {
                                          if(e.target.value.trim() != ""){
                                            blockDataSet(
                                              selectedBlock,
                                              data?.name,
                                              e.target.value
                                            );
                                          }else{
                                            blockDataSet(
                                              selectedBlock,
                                              data?.name,
                                              ""
                                            );
                                          }
                                        }}
                                        className={
                                          "form-control " +
                                          (validationErrors.includes(data?.name)
                                            ? "error-border"
                                            : "") +
                                          " " +
                                          (allErrors.includes(
                                            data?.name.replace("[]", "")
                                          )
                                            ? "error-border"
                                            : "")
                                        }
                                      />
                                    )}
                                  </div>
                                );
                              } else if (data.type == "date") {
                                return (
                                  <div
                                    className={
                                      "form-group " + (isX ? "d-none" : "")
                                    }
                                  >
                                    <label className="font-bold" htmlFor="">
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                    </label>
                                    <input
                                      id={data?.name.replace("[]", "")}
                                      type="date"
                                      value={
                                        blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                        ] &&
                                          blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          ? blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          : ""
                                      }
                                      onChange={(e) => {
                                        if (e.target.value.length == 10) {
                                          blockDataSet(
                                            selectedBlock,
                                            data?.name,
                                            e.target.value
                                          );
                                        }
                                      }}
                                      className={
                                        "form-control " +
                                        (validationErrors.includes(data?.name)
                                          ? "error-border"
                                          : "") +
                                        " " +
                                        (allErrors.includes(
                                          data?.name.replace("[]", "")
                                        )
                                          ? "error-border"
                                          : "")
                                      }
                                    />
                                  </div>
                                );
                              } else if (data.type == "select") {
                                return (
                                  <div
                                    className={
                                      "form-group " + (isX ? "d-none" : "")
                                    }
                                  >
                                    <label className="font-bold" htmlFor="">
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                    </label>
                                    <select
                                      id={data?.name.replace("[]", "")}
                                      name=""
                                      className={
                                        "form-control " +
                                        (validationErrors.includes(data?.name)
                                          ? "error-border"
                                          : "") +
                                        " " +
                                        (allErrors.includes(
                                          data?.name.replace("[]", "")
                                        )
                                          ? "error-border"
                                          : "")
                                      }
                                      onChange={(e) => {
                                        blockDataSet(
                                          selectedBlock,
                                          data?.name,
                                          e.target.value
                                        );
                                      }}
                                      value={
                                        blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                        ] &&
                                          blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          ? blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          : ""
                                      }
                                    >
                                      {data.values.map((valueSelect) => {
                                        return (
                                          <option value={valueSelect.value}>
                                            {valueSelect.label}
                                          </option>
                                        );
                                      })}
                                    </select>
                                  </div>
                                );
                              } else if (data.type == "checkbox-group") {
                                if (data.name == "payment-plan[]") {
                                  return (
                                    <div className={isX ? "d-none" : ""}>
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                      {data?.className?.includes(
                                        "project-not-change"
                                      ) ? (
                                        <div className="info-small-area">
                                          Bu alan projelerde seçilmesi zorunlu
                                          alandır değiştiremezsiniz
                                        </div>
                                      ) : (
                                        ""
                                      )}
                                      <div className="checkbox-groups">
                                        <div className="mb-3">
                                          <div className="row">
                                            {data.values.map((valueCheckbox) => {
                                              return (
                                                <div className="col-md-3">
                                                  <FormControlLabel
                                                    control={
                                                      <Checkbox
                                                        checked={
                                                          blocks[selectedBlock]
                                                            ?.rooms[
                                                            selectedRoom
                                                          ] &&
                                                            blocks[selectedBlock]
                                                              ?.rooms[selectedRoom][
                                                            data.name
                                                            ] &&
                                                            blocks[selectedBlock]
                                                              ?.rooms[selectedRoom]
                                                            ? blocks[
                                                              selectedBlock
                                                            ]?.rooms[
                                                              selectedRoom
                                                            ][
                                                              data.name
                                                            ].includes(
                                                              valueCheckbox.value
                                                            )
                                                            : false
                                                        }
                                                        onChange={(e) => {
                                                          if (
                                                            !data?.className?.includes(
                                                              "project-not-change"
                                                            )
                                                          ) {
                                                            blockCheckboxDataSet(
                                                              selectedBlock,
                                                              data?.name,
                                                              valueCheckbox?.value,
                                                              e
                                                            );
                                                            setCheckedItemsFunc(
                                                              data?.name,
                                                              e.target.checked
                                                            );
                                                          }
                                                        }}
                                                      />
                                                    }
                                                    label={valueCheckbox.label}
                                                  />
                                                </div>
                                              );
                                            })}
                                          </div>
                                          {
                                            checkedItems.find((checkedItem) => {
                                              if(
                                                checkedItem.roomOrder == selectedRoom &&
                                                checkedItem.name == "payment-plan"
                                              ){
                                                return checkedItem
                                              }
                                            }) ? 
                                              <div>
                                                <label htmlFor="" className="font-bold">
                                                  Ödeme Planı
                                                </label>
                                                <button
                                                  className="btn btn-primary add-project-pay-dec-button d-block"
                                                  onClick={() => {
                                                    setPayDecOpen(true);
                                                  }}
                                                >
                                                  Ödeme Planını Yönet (
                                                  {blocks[selectedBlock]?.rooms[
                                                    selectedRoom
                                                  ]
                                                    ? blocks[selectedBlock]?.rooms[
                                                      selectedRoom
                                                    ]?.payDecs?.length
                                                    : 0}
                                                  )
                                                </button>
                                              </div>
                                            : ''
                                          }
                                          
                                        </div>
                                      </div>
                                    </div>
                                  );
                                } else {
                                  return (
                                    <div className={isX ? "d-none" : ""}>
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                      {data?.className?.includes(
                                        "project-not-change"
                                      ) ? (
                                        <div className="info-small-area">
                                          Bu alan projelerde seçilmesi zorunlu
                                          alandır değiştiremezsiniz
                                        </div>
                                      ) : (
                                        ""
                                      )}
                                      <div className="checkbox-groups">
                                        <div className="row">
                                          {data.values.map((valueCheckbox) => {
                                            return (
                                              <div className="col-md-3">
                                                <FormControlLabel
                                                  control={
                                                    <Checkbox
                                                      checked={
                                                        blocks[selectedBlock]
                                                          ?.rooms[
                                                          selectedRoom
                                                        ] &&
                                                          blocks[selectedBlock]
                                                            ?.rooms[selectedRoom][
                                                          data.name
                                                          ] &&
                                                          blocks[selectedBlock]
                                                            ?.rooms[selectedRoom]
                                                          ? blocks[
                                                            selectedBlock
                                                          ]?.rooms[
                                                            selectedRoom
                                                          ][
                                                            data.name
                                                          ].includes(
                                                            valueCheckbox.value
                                                          )
                                                          : false
                                                      }
                                                      onChange={(e) => {
                                                        if (
                                                          !data?.className?.includes(
                                                            "project-not-change"
                                                          )
                                                        ) {
                                                          blockCheckboxDataSet(
                                                            selectedBlock,
                                                            data?.name,
                                                            valueCheckbox?.value,
                                                            e
                                                          );
                                                          setCheckedItemsFunc(
                                                            data?.name,
                                                            e.target.checked
                                                          );
                                                        }
                                                      }}
                                                    />
                                                  }
                                                  label={valueCheckbox.label}
                                                />
                                              </div>
                                            );
                                          })}
                                        </div>
                                      </div>
                                    </div>
                                  );
                                }
                              } else if (data.type == "file") {
                                return (
                                  <div
                                    className={
                                      "form-group " + (isX ? "d-none" : "")
                                    }
                                  >
                                    <label className="font-bold" htmlFor="">
                                      {data.label}{" "}
                                      {data.required ? (
                                        <span className="required-span">*</span>
                                      ) : (
                                        ""
                                      )}
                                    </label>
                                    <input
                                      id={data?.name.replace("[]", "")}
                                      accept="image/png, image/gif, image/jpeg"
                                      onChange={(event) => {
                                        changeFormImage(
                                          selectedBlock,
                                          data?.name,
                                          event
                                        );
                                      }}
                                      type="file"
                                      className={
                                        "form-control " +
                                        (validationErrors.includes(data?.name)
                                          ? "error-border"
                                          : "") +
                                        " " +
                                        (allErrors.includes(
                                          data?.name.replace("[]", "")
                                        )
                                          ? "error-border"
                                          : "")
                                      }
                                    />
                                    <div className="project_imaget">
                                      {
                                        blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                        ] &&
                                          blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name + "_imagex"] ? 
                                          <img
                                        src={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name + "_imagex"]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name + "_imagex"]
                                            : ""
                                        }
                                        alt=""
                                      /> : ""
                                      }
                                      
                                    </div>
                                  </div>
                                );
                              }
                            }
                          }
                        }
                      })}
                  </div>
                ) : (
                  ""
                )}
              </div>
            </div>
          </div>
        </>
      )}

      <Modal
        open={open}
        onClose={() => {
          setOpen(false);
        }}
        aria-labelledby="modal-modal-title"
        aria-describedby="modal-modal-description"
      >
        <Box sx={style}>
          <div className="form-group">
            <label htmlFor="">Blok Adı</label>
            <input
              type="text"
              value={blockName}
              onChange={(e) => {
                setBlockName(e.target.value);
              }}
              className="form-control"
            />
          </div>
          <div className="form-group">
            <label htmlFor="">Bu Blokta Kaç Tane İlan Var</label>
            <input
              type="number"
              value={roomCount == 0 ? "" : roomCount}
              onChange={(e) => {
                setRoomCount(e.target.value);
              }}
              className="form-control"
            />
          </div>
          <div className="form-group">
            <button
              class="btn btn-success confirm-button-block"
              onClick={addBlock}
            >
              Bloğu Ekle
            </button>
          </div>
        </Box>
      </Modal>

      <PayDecModal
        open={payDecOpen}
        blocks={blocks}
        setBlocks={setBlocks}
        selectedBlock={selectedBlock}
        selectedRoom={selectedRoom}
        setOpen={setPayDecOpen}
      />
    </>
  );
}
export default BlockRooms;
