import React, { useEffect, useState } from "react";
import "./TopCreateProjectNavigator.css";

function TopCreateProjectNavigator({ step, setStep }) {

  

  return (
    <div id="navbarDefault">
      <div className="progress-area">
        <div className={"progress-line step" + step}>
          <ol>
            <li
              onClick={() => {
                setStep(1);
              }}
              className={step === 1 ? "current" : step > 1 ? "done" : ""}
            >
              <a className="step-counter">
                <span className="step-counter-number">1</span>
              </a>
              <a onClick={() => setStep(1)}>Kategori Seçimi</a>
            </li>
            <li
              onClick={() => {
                setStep(2);
              }}
              className={step === 2 ? "current" : step > 2 ? "done" : ""}
            >
              <a className="step-counter">
                <span className="step-counter-number">2</span>
              </a>
              <a onClick={() => setStep(2)}>İlan Detayları</a>
            </li>
            <li
              onClick={() => {
                setStep(3);
              }}
              className={step === 3 ? "current" : step > 3 ? "done" : ""}
            >
              <a className="step-counter">
                <span className="step-counter-number">3</span>
              </a>
              <a onClick={() => setStep(3)}>Önizleme</a>
            </li>
            <li className={step === 4 ? "current" : step > 4 ? "done" : ""}>
              <a className="step-counter">
                <span className="step-counter-number">4</span>
              </a>
              <a onClick={() => setStep(4)}>Tebrikler</a>
            </li>
          </ol>
        </div>
      </div>
    </div>
  );
}

export default TopCreateProjectNavigator;
// import React from "react";
// import "./TopCreateProjectNavigator.css";

// function TopCreateProjectNavigator({ step, setStep }) {
//   return (
//     <div id="navbarDefault">
//       <div className="progress-area">
//         <div className={"progress-line step" + step}>
//           <ol>
//             <li
//               onClick={() => {
//                 if (step >= 1) setStep(1);
//               }}
//               className={step === 1 ? "current" : step > 1 ? "done" : ""}
//             >
//               <a className="step-counter">
//                 <span className="step-counter-number">1</span>
//               </a>
//               <a onClick={() => {
//                 if (step >= 1) setStep(1);
//               }}>Kategori Seçimi</a>
//             </li>
//             <li
//               onClick={() => {
//                 if (step >= 2) setStep(2);
//               }}
//               className={step === 2 ? "current" : step > 2 ? "done" : ""}
//             >
//               <a className="step-counter">
//                 <span className="step-counter-number">2</span>
//               </a>
//               <a onClick={() => {
//                 if (step >= 2) setStep(2);
//               }}>İlan Detayları</a>
//             </li>
//             <li
//               onClick={() => {
//                 if (step >= 3) setStep(3);
//               }}
//               className={step === 3 ? "current" : step > 3 ? "done" : ""}
//             >
//               <a className="step-counter">
//                 <span className="step-counter-number">3</span>
//               </a>
//               <a onClick={() => {
//                 if (step >= 3) setStep(3);
//               }}>Önizleme</a>
//             </li>
//             <li
//               onClick={() => {
//                 if (step >= 4) setStep(4);
//               }}
//               className={step === 4 ? "current" : step > 4 ? "done" : ""}
//             >
//               <a className="step-counter">
//                 <span className="step-counter-number">4</span>
//               </a>
//               <a onClick={() => {
//                 if (step >= 4) setStep(4);
//               }}>Tebrikler</a>
//             </li>
//           </ol>
//         </div>
//       </div>
//     </div>
//   );
// }

// export default TopCreateProjectNavigator;
