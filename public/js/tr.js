/* Turkish locals for flatpickr */
var flatpickr = flatpickr || { l10ns: {} };
flatpickr.l10ns.tr = {};

flatpickr.l10ns.tr.firstDayOfWeek = 1;

flatpickr.l10ns.tr.weekdays = {
    shorthand: ["Paz", "Pzt", "Sal", "Çar", "Per", "Cum", "Cmt"],
    longhand: ["Pazar", "Pazartesi", "Salı", "Çarşamba", "Perşembe", "Cuma", "Cumartesi"]
};

flatpickr.l10ns.tr.months = {
    shorthand: ["Oca", "Şub", "Mar", "Nis", "May", "Haz", "Tem", "Ağu", "Eyl", "Eki", "Kas", "Ara"],
    longhand: ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"]
};

flatpickr.l10ns.tr.ordinal = function (nth) {
    if (nth === 1 || nth === 21 || nth === 31) {
        return "inci";
    }

    if (nth === 2 || nth === 22) {
        return "nci";
    }

    if (nth === 3 || nth === 23) {
        return "üncü";
    }

    return "üncü";
};

if (typeof module !== "undefined") {
    module.exports = flatpickr.l10ns;
}
