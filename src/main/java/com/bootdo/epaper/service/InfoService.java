package com.bootdo.epaper.service;

import com.bootdo.epaper.domain.InfoDO;

import java.util.List;
import java.util.Map;

/**
 * 
 * 
 * @author chglee
 * @email 1992lcg@163.com
 * @date 2018-12-11 20:14:45
 */
public interface InfoService {
	
	InfoDO get(Integer id);
	
	List<InfoDO> list(Map<String, Object> map);
	
	int count(Map<String, Object> map);
	
	int save(InfoDO info);
	
	int update(InfoDO info);
	
	int remove(Integer id);
	
	int batchRemove(Integer[] ids);
}
