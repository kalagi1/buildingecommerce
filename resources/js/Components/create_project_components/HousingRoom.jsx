import React, { useCallback, useEffect, useState } from "react";
import { dotNumberFormat, getLargeData, saveLargeData, telNumberFormat } from "../../define/variables";
import {
  Alert,
  Checkbox,
  FormControlLabel,
  Switch,
  Tooltip,
} from "@mui/material";
import DateInputComponent from "./DateInput";


let formData = [];

function HousingRoom({
  slug,
  allErrors,
  anotherBlockErrors,
  selectedBlock,
  selectedRoom,
  blocks,
  setBlocks,
  selectedHousingType,
}) {
  const [validationErrors, setValidationErrors] = useState([]);
  if (selectedHousingType?.housing_type?.form_json) {
    formData = JSON.parse(selectedHousingType.housing_type.form_json);
  } else {
    // Handle the case where form_json is undefined or null
    console.warn("form_json is undefined or null");
  }
  const [rendered, setRendered] = useState(0);
  const [checkedItems, setCheckedItems] = useState([]);
  const [loadingStart,setLoadingStart] = useState(false);

  useEffect(() => {
    async function saveData() {
      try {
        await saveLargeData('checkedItems', checkedItems);
      } catch (e) {
        console.log(e);
      }
    }

    if (loadingStart) {
      saveData();
    }
  }, [checkedItems, loadingStart]);

  useEffect(() => {
    async function fetchData() {
      const storedData = await getLargeData('checkedItems');
      if (storedData) {
        setCheckedItems(storedData);
        setLoadingStart(true);
      } else {
        setLoadingStart(true);
      }
    }

    fetchData();
  }, []);

  const setCheckedItemsFunc = (name, checked, order) => {
    if (checked) {
      setCheckedItems([
        ...checkedItems,
        {
          roomOrder: 0,
          name: name.replace("[]", ""),
        },
      ]);
    } else {
      var newItems = checkedItems.filter((checkedItem) => {
        if (
          checkedItem.roomOrder == 0 &&
          checkedItem.name == name.replace("[]", "")
        ) {
        } else {
          return checkedItem;
        }
      });

      setCheckedItems(newItems);
    }
  };
  const blockDataSet = (blockIndex, keyx, value) => {
    console.log(blocks);
    var newDatas = blocks.map((block, key) => {
      if (blockIndex == key) {
        var newData2 = block.rooms.map((room, keyRoom) => {
          if (keyRoom == selectedRoom) {
            console.log(room,selectedRoom,keyRoom);
            return {
              ...room,
              [keyx]: value,
            };
          } else {
            return room;
          }
        });
        console.log(newData2);
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
  const checkItem = (data) => {
    if(slug == "satilik"){
      if(!data?.className
        ?.split(" ")
        .find((classx) => classx == "project-disabled") &&
      !data?.className?.includes("only-show-project-rent") &&
      !data?.className?.includes("only-show-project-daliy-rent") &&
      !data?.className?.includes("only-show-project-sale")){
        return true;
      }
    }

    if(slug == "devren-satilik"){
      if(!data?.className
        ?.split(" ")
        .find((classx) => classx == "project-disabled") &&
      !data?.className?.includes("only-show-project-rent") &&
      !data?.className?.includes("only-show-project-daliy-rent") &&
      !data?.className?.includes("only-show-project-sale")){
        return true;
      }
    }

    if(slug == "kiralik"){
      if(!data?.className
        ?.split(" ")
        .find((classx) => classx == "rent-disabled") &&
      !data?.className?.includes("only-show-project-rent") &&
      !data?.className?.includes("only-show-project-daliy-rent") &&
      !data?.className?.includes("only-show-project-sale")){
        return true;
      }
    }

    if(slug == "devren-kiralik"){
      if(!data?.className
        ?.split(" ")
        .find((classx) => classx == "rent-disabled") &&
      !data?.className?.includes("only-show-project-rent") &&
      !data?.className?.includes("only-show-project-daliy-rent") &&
      !data?.className?.includes("only-show-project-sale")){
        return true;
      }
    }

    if(slug == "gunluk-kiralik"){
      if(!data?.className
        ?.split(" ")
        .find((classx) => classx == "daily-rent-disabled") &&
      !data?.className?.includes("only-show-project-rent") &&
      !data?.className?.includes("only-show-project-daliy-rent") &&
      !data?.className?.includes("only-show-project-sale")){
        return true;
      }
    }
  }

  return (
    <>
      <div className="section-title mt-5">
        <h2>İlan Özellikleri </h2>
      </div>
      <div className="card p-4" style={{ position: "relative" }}>
        <div id="housing-forms">
          {anotherBlockErrors.length > 0 ? (
            <Alert icon={false} severity="error">
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
            <div className="housing-form mt-3">
              {formData.map((data, i) => {
                if (checkItem(data)) {
                  if (
                    !data?.className?.split(" ").includes("disabled-housing") &&
                    !data?.className
                      ?.split(" ")
                      .includes("cover-image-by-housing-type")
                  ) {
                    var isX = null;
                    if (data?.className?.includes("--if-show-checked-")) {
                      isX = !checkedItems.find((checkedItem) => {
                        return (
                          checkedItem.roomOrder == 0 &&
                          checkedItem.name ==
                            data?.className?.split("--if-show-checked-")[1]
                        );
                      });
                    }
                    if (data.type == "text") {
                      return (
                        <div className={"form-group " + (isX ? "d-none" : "")}>
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
                                <span className="required-span">*</span>
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
                                blocks[selectedBlock]?.rooms[selectedRoom] &&
                                blocks[selectedBlock]?.rooms[selectedRoom][
                                  data.name
                                ]
                                  ? blocks[selectedBlock]?.rooms[selectedRoom][
                                      data.name
                                    ]
                                  : ""
                              }
                              onChange={(e) => {
                                if(data?.className?.includes('max_number=')){
                                  var maxNumber = data?.className?.split('max_number=--') 
                                  maxNumber = maxNumber[1].split("--");
                                  maxNumber = maxNumber[0];

                                  if(parseInt(e.target.value.replace('.','')) > parseInt(maxNumber)){
                                    blockDataSet(
                                      selectedBlock,
                                      data?.name,
                                      dotNumberFormat(maxNumber)
                                    );
                                  }else{
                                    blockDataSet(
                                      selectedBlock,
                                      data?.name,
                                      dotNumberFormat(e.target.value)
                                    );
                                  }
                                }else{
                                  blockDataSet(
                                    selectedBlock,
                                    data?.name,
                                    dotNumberFormat(e.target.value)
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
                          ) : data?.className?.includes("tel-only") ? (
                            <input
                              id={data?.name.replace("[]", "")}
                              type="text"
                              value={
                                blocks[selectedBlock]?.rooms[selectedRoom] &&
                                blocks[selectedBlock]?.rooms[selectedRoom][
                                  data.name
                                ]
                                  ? blocks[selectedBlock]?.rooms[selectedRoom][
                                      data.name
                                    ]
                                  : ""
                              }
                              onChange={(e) => {
                                blockDataSet(
                                  selectedBlock,
                                  data?.name,
                                  telNumberFormat(e.target.value)
                                );
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
                                blocks[selectedBlock]?.rooms[selectedRoom] &&
                                blocks[selectedBlock]?.rooms[selectedRoom][
                                  data.name
                                ]
                                  ? blocks[selectedBlock]?.rooms[selectedRoom][
                                      data.name
                                    ]
                                  : ""
                              }
                              onChange={(e) => {
                                blockDataSet(
                                  selectedBlock,
                                  data?.name,
                                  e.target.value
                                );
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
                      if (data.subtype == "time") {
                        return (
                          <div
                            className={"form-group " + (isX ? "d-none" : "")}
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
                                  <span className="required-span">*</span>
                                ) : (
                                  ""
                                )}
                              </div>
                            </label>
                            <input
                              id={data?.name.replace("[]", "")}
                              type="time"
                              value={
                                blocks[selectedBlock]?.rooms[selectedRoom] &&
                                blocks[selectedBlock]?.rooms[selectedRoom][
                                  data.name
                                ]
                                  ? blocks[selectedBlock]?.rooms[selectedRoom][
                                      data.name
                                    ]
                                  : ""
                              }
                              onChange={(e) => {
                                blockDataSet(
                                  selectedBlock,
                                  data?.name,
                                  e.target.value
                                );
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
                      } else {
                        var hasMin = false;
                        var hasMax = false;
                        var minimumDate = "";
                        var maximumDate = "";

                        if(data?.className?.includes('min_date=--')){
                          var minDate = data?.className?.split('min_date=--') 
                          minDate = minDate[1].split("--");
                          minDate = minDate[0];
                          hasMin = true;

                          if(minDate == "now"){
                            minimumDate = new Date();
                          }else{
                            minimumDate = new Date(minDate);
                          }
                        }

                        if(data?.className?.includes('max_date=--')){
                          var maxDate = data?.className?.split('max_date=--') 
                          maxDate = maxDate[1].split("--");
                          maxDate = maxDate[0];
                          hasMax = true;

                          if(maxDate == "now"){
                            maximumDate = new Date();
                          }else{
                            maximumDate = new Date(maxDate);
                          }
                        }
                        return (
                          <div className={"form-group " + (isX ? "d-none" : "")}>
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
                                  <span className="required-span">*</span>
                                ) : (
                                  ""
                                )}
                              </div>
                            </label>
                            <DateInputComponent blocks={blocks} selectedBlock={selectedBlock} selectedRoom={selectedRoom} data={data} blockDataSet={blockDataSet} hasMax={hasMax} hasMin={hasMin} maximumDate={maximumDate} minimumDate={minimumDate} validationErrors={validationErrors} allErrors={allErrors}/>
                          </div>
                        );
                      }
                    } else if (data.type == "select") {
                      return (
                        <div className={"form-group " + (isX ? "d-none" : "")}>
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
                                <span className="required-span">*</span>
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
                              (allErrors.includes(data?.name.replace("[]", ""))
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
                              blocks[selectedBlock]?.rooms[selectedRoom] &&
                              blocks[selectedBlock]?.rooms[selectedRoom][
                                data.name
                              ]
                                ? blocks[selectedBlock]?.rooms[selectedRoom][
                                    data.name
                                  ]
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
                          <div>
                            <div>
                              <label className="mt-3 font-bold" htmlFor="">
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
                                    <span className="required-span">*</span>
                                  ) : (
                                    ""
                                  )}
                                </div>
                              </label>
                              <div
                                className="checkbox-groups"
                                id={data?.name.replace("[]", "")}
                              >
                                <div className="row">
                                  {data.values.map((valueCheckbox) => {
                                    return (
                                      <div className="col-md-3">
                                        <FormControlLabel
                                          control={
                                            <Switch
                                              label={label}
                                              checked={
                                                blocks[selectedBlock]?.rooms[
                                                  selectedRoom
                                                ][data.name] &&
                                                blocks[selectedBlock]?.rooms[
                                                  selectedRoom
                                                ]
                                                  ? blocks[
                                                      selectedBlock
                                                    ]?.rooms[selectedRoom][
                                                      data.name
                                                    ].includes(
                                                      valueCheckbox.value
                                                    )
                                                  : false
                                              }
                                              onChange={(e) => {
                                                blockCheckboxDataSet(
                                                  selectedBlock,
                                                  data?.name,
                                                  valueCheckbox?.value,
                                                  e
                                                );
                                                setCheckedItemsFunc(
                                                  data?.name,
                                                  e.target.checked,
                                                  i
                                                );
                                              }}
                                            />
                                          }
                                          label={valueCheckbox.label}
                                        />
                                      </div>
                                    );
                                  })}
                                  {allErrors.includes(
                                    data?.name.replace("[]", "")
                                  ) ? (
                                    <Alert severity="error">
                                      Harita üzerine bir konum seçin
                                    </Alert>
                                  ) : (
                                    ""
                                  )}
                                </div>
                              </div>
                            </div>
                          </div>
                        );
                      } else {
                        return (
                          <div className={isX ? "d-none" : ""}>
                            <label className="mt-3 font-bold" htmlFor="">
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
                                  <span className="required-span">*</span>
                                ) : (
                                  ""
                                )}
                              </div>
                            </label>
                            <div className="checkbox-groups">
                              <div className="row">
                                {data.values.map((valueCheckbox) => {
                                  return (
                                    <div className="col-md-3">
                                      <FormControlLabel
                                        control={
                                          <Checkbox
                                            checked={
                                              blocks[selectedBlock]?.rooms[
                                                selectedRoom
                                              ][data.name] &&
                                              blocks[selectedBlock]?.rooms[
                                                selectedRoom
                                              ]
                                                ? blocks[selectedBlock]?.rooms[
                                                    selectedRoom
                                                  ][data.name].includes(
                                                    valueCheckbox.value
                                                  )
                                                : false
                                            }
                                            onChange={(e) => {
                                              blockCheckboxDataSet(
                                                selectedBlock,
                                                data?.name,
                                                valueCheckbox?.value,
                                                e
                                              );
                                              console.log(e.target.checked);
                                              setCheckedItemsFunc(
                                                data?.name,
                                                e.target.checked,
                                                i
                                              );
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
                        <div className={"form-group " + (isX ? "d-none" : "")}>
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
                                <span className="required-span">*</span>
                              ) : (
                                ""
                              )}
                            </div>
                          </label>
                          <input
                            id={data?.name.replace("[]", "")}
                            accept="image/png, image/gif, image/jpeg"
                            onChange={(event) => {
                              changeFormImage(selectedBlock, data?.name, event);
                            }}
                            type="file"
                            className={
                              "form-control " +
                              (validationErrors.includes(data?.name)
                                ? "error-border"
                                : "") +
                              " " +
                              (allErrors.includes(data?.name.replace("[]", ""))
                                ? "error-border"
                                : "")
                            }
                          />
                          <div className="project_imaget">
                            <img
                              src={
                                blocks[selectedBlock]?.rooms[selectedRoom] &&
                                blocks[selectedBlock]?.rooms[selectedRoom][
                                  data.name + "_imagex"
                                ]
                                  ? blocks[selectedBlock]?.rooms[selectedRoom][
                                      data.name + "_imagex"
                                    ]
                                  : ""
                              }
                              alt=""
                            />
                          </div>
                        </div>
                      );
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
    </>
  );
}
export default HousingRoom;
