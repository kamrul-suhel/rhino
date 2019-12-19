import dealership from "./dealership"
import brand from "./brand"
import User from "./user"

export default {
    ...dealership,
    ...brand,
    ...User
}
