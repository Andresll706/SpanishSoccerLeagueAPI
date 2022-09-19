import {PositionInputDto} from "./positionInputDto";

export interface PlayersInputDto {
  id?: number;
  name?: string | null;
  image?: string | null;
  age?: number | null;
  position?: Array<PositionInputDto> | null;
}
